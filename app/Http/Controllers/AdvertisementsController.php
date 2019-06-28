<?php

namespace App\Http\Controllers;

use App\Advertisement;
use App\DeviceAdvertisement;
use App\Events\AdvertisementAdded;
use App\Events\AdvertisementRemoved;
use App\Events\AdvertisementUpdated;
use App\Helpers\PhotosHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdvertisementsController extends Controller
{
    public function index() {
        $advertisements = Auth::user()->advertisements()->paginate();
        return view('advertisements.index', compact('advertisements'));
    }

    public function adminIndex() {
        $advertisements = Advertisement::paginate();
        return view('admin.advertisements.index', compact('advertisements'));
    }

    public function create() {
        $devices = Auth::user()->devices()->get();
        return view('advertisements.create', compact('devices'));
    }

    public function store(Request $request) {
        $user = Auth::user();
        $advertisement = $user->advertisements()->create();
        $devices = $request['devices'];
        $durations = $request['durations'];
        foreach($devices as $key => $device) {
            $duration = $durations[$key];
            DeviceAdvertisement::create([
                'device_id' => $device,
                'advertisement_id' => $advertisement->id,
                'duration' => $duration,
            ]);
            event(new AdvertisementAdded($device, [
                'id' => $advertisement->id,
                'image_url' => PhotosHelper::getPhotoURL('advertisement', $advertisement->id),
                'duration' => $duration,
            ]));
        }
        $file = $request->file('photo');
        PhotosHelper::savePhoto($file, 'advertisement', $advertisement->id);
        Session::flash('info', ['action'=>'created']);
        return redirect()->action('AdvertisementsController@index');
    }

    public function edit($id) {
        $advertisement = Advertisement::find($id);
        if (!$advertisement) {
            Session::flash('danger', 'Advertisement not found');
        }
        else {
            $user = Auth::user();
            if ($user->id != $advertisement->publisher_id) {
                Session::flash('danger', "You don't have permission to edit this advertisement");
            } else {
                $advertisement_devices = $advertisement->devices()->get();
                $advertisement_devices_ids = $advertisement_devices->map(function($ad_dev) {
                    return $ad_dev->id;
                });
                $other_devices = $user->devices()->whereNotIn('devices.id', $advertisement_devices_ids)->get();
                return view('advertisements.edit',
                    compact('advertisement', 'other_devices', 'advertisement_devices'));
            }
        }
        return redirect()->action('AdvertisementsController@index');
    }

    public function update(Request $request, $id) {
        $advertisement = Advertisement::find($id);
        if (!$advertisement) {
            Session::flash('danger', 'Advertisement not found');
        }
        else {
            $user = Auth::user();
            if ($user->id != $advertisement->publisher_id) {
                Session::flash('danger', "You don't have permission to edit this advertisement");
            } else {
                // Add new devices
                $new_devices = $request['new_devices'];
                if ($new_devices) {
                    $new_durations = $request['new_durations'];
                    foreach ($new_devices as $key => $new_device) {
                        $new_duration = $new_durations[$key];
                        DeviceAdvertisement::create([
                            'device_id' => $new_device,
                            'advertisement_id' => $advertisement->id,
                            'duration' => $new_duration,
                        ]);
                        event(new AdvertisementAdded($new_device, [
                            'id' => $advertisement->id,
                            'image_url' => PhotosHelper::getPhotoURL('advertisement', $advertisement->id),
                            'duration' => $new_duration,
                        ]));
                    }
                }
                // Update existing devices
                $update_devices = $request['update_devices'];
                if ($update_devices) {
                    $update_durations = $request['update_durations'];
                    foreach ($update_devices as $key => $update_device) {
                        $update_duration = $update_durations[$key];
                        $device_advertisement = DeviceAdvertisement::
                            where('advertisement_id', $advertisement->id)
                            ->where('device_id', $update_device)->first();
                        if ($device_advertisement && $update_duration != $device_advertisement->duration) {
                            $device_advertisement->update(['duration' => $update_duration]);
                        }
                        event(new AdvertisementUpdated($update_device, [
                            'id' => $advertisement->id,
                            'image_url' => PhotosHelper::getPhotoURL('advertisement', $advertisement->id),
                            'duration' => $update_duration,
                        ]));
                    }
                }
                // Remove existing devices
                $remove_devices = $request['remove_devices'];
                if ($remove_devices) {
                    foreach ($remove_devices as $remove_device) {
                        $device_advertisement = DeviceAdvertisement::
                            where('advertisement_id', $advertisement->id)
                            ->where('device_id', $remove_device)->first();
                        if ($device_advertisement) {
                            $device_advertisement->delete();
                        }
                        event(new AdvertisementRemoved($remove_device, ['id' => $advertisement->id]));
                    }
                }
                // Update advertisement {updated at column}
                $advertisement->touch();
                Session::flash('info', ['action' => 'updated']);
            }
        }
        return redirect()->action('AdvertisementsController@index');
    }

    public function destroy($id) {
        $advertisement = Advertisement::find($id);
        if (!$advertisement) {
            Session::flash('danger', 'Advertisement not found');
        }
        else {
            $user = Auth::user();
            if ($user->id != $advertisement->publisher_id) {
                Session::flash('danger', "You don't have permission to edit this advertisement");
            } else {
                $advertisement->delete();
                PhotosHelper::removePhoto('advertisement', $advertisement->id);
                $devices = $advertisement->devices()->get();
                foreach ($devices as $device) {
                    event(new AdvertisementRemoved($device->id, $advertisement->id));
                }
                Session::flash('info', ['action' => 'deleted']);
            }
        }
        return redirect()->action('AdvertisementsController@index');
    }

    public function adminDestroy($id) {
        $advertisement = Advertisement::find($id);
        if (!$advertisement) {
            Session::flash('danger', 'Advertisement not found');
        }
        else {
            $advertisement->delete();
            PhotosHelper::removePhoto('advertisement', $advertisement->id);
            $devices = $advertisement->devices()->get();
            foreach ($devices as $device) {
                event(new AdvertisementRemoved($device->id, $advertisement->id));
            }
            Session::flash('info', ['action' => 'deleted']);
        }
        return redirect()->action('AdvertisementsController@adminIndex');
    }

    public function getDeviceAdvertisements() {
        $advertisements = auth()->user()->advertisements()
            ->select('advertisements.id', 'device_advertisements.duration')->get()
            ->map(function($advertisement) {
                return [
                    'id' => $advertisement->id,
                    'image_url' => PhotosHelper::getPhotoURL('advertisement', $advertisement->id),
                    'duration' => $advertisement->duration,
                ];
            });
        return response()->json($advertisements);
    }
}
