<?php

namespace App\Http\Controllers;

use App\Device;
use App\Role;
use App\User;
use App\UserDevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PublishersManagementController extends Controller
{
    public function index() {
        $publishers = Role::where('name', 'publisher')->first()->users()->paginate();
        return view('admin.publishers.index', compact('publishers'));
    }

    public function editPermissions($id) {
        $publisher = User::find($id);
        if (!$publisher) {
            Session::flash('danger', 'Publisher not found');
        } else {
            if ($publisher->role->name != 'publisher') {
                Session::flash('danger', 'User is not a publisher');
            } else {
                $publisher_devices = $publisher->devices()->get();
                $publisher_devices_ids = $publisher_devices->map(function($pub_dev) {
                    return $pub_dev->id;
                });
                $other_devices = Device::whereNotIn('id', $publisher_devices_ids)->get();
                return view('admin.publishers.editPermissions',
                    compact('publisher', 'publisher_devices', 'other_devices'));
            }
        }
        return redirect()->action('PublishersManagementController@index');
    }

    public function updatePermissions(Request $request, $id) {
        $publisher = User::find($id);
        if (!$publisher) {
            Session::flash('danger', 'Publisher not found');
        } else {
            if ($publisher->role->name != 'publisher') {
                Session::flash('danger', 'User is not a publisher');
            } else {
                // Add new devices
                $new_devices = $request['new_devices'];
                if ($new_devices) {
                    foreach ($new_devices as $new_device) {
                        UserDevice::create([
                            'device_id' => $new_device,
                            'user_id' => $publisher->id,
                        ]);
                    }
                }
                // Remove existing devices
                $remove_devices = $request['remove_devices'];
                if ($remove_devices) {
                    foreach ($remove_devices as $remove_device) {
                        $publisher_device = UserDevice::find($remove_device);
                        if ($publisher_device) {
                            $publisher_device->delete();
                        }
                    }
                }
                Session::flash('info', $publisher->name.' permissions has been updated successfully.');            }
        }
        return redirect()->action('PublishersManagementController@index');
    }
}
