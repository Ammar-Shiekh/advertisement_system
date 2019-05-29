window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo'

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    auth: {
        headers: {
            Authorization: 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImY3ZTVlMTAzZWE3MzJjMTI5NzY1YTliMmMzOTM0N2ZhOGE4OTU5MjRjNDA5ZjgyOTA4ZDg5NTFjZTBkOGZlNTA2M2M1YTI1MDBlOTdhZDdiIn0.eyJhdWQiOiIxIiwianRpIjoiZjdlNWUxMDNlYTczMmMxMjk3NjVhOWIyYzM5MzQ3ZmE4YTg5NTkyNGM0MDlmODI5MDhkODk1MWNlMGQ4ZmU1MDYzYzVhMjUwMGU5N2FkN2IiLCJpYXQiOjE1NTkwOTYyNDgsIm5iZiI6MTU1OTA5NjI0OCwiZXhwIjoxNTkwNzE4NjQ3LCJzdWIiOiI3Iiwic2NvcGVzIjpbXX0.FKeE9Z-wv2yUNQPl-qsbu9baYGTdbQ6DuzaI1R8azR6l1CIP9uRI4hCaoWvgx0GXWWLPRNhfQl-YD3KP2YOraW16-h4ie_95B9VQrpFxXnlqKojsfh1xSrSNSl5HncslMWQPVjoesBpM5y_cpG19PGgu-SWo0W6s9Fiz_Nm70oyyZB9mSqU8PVQvAOSNr6TMR0aC3iMLFfkyZkTSwj8EoRyD2LGW6v4PFriqx8JLbZASCOiUYBlYnunWrTFDOAenZcoa5Sw7u7kbSvYehjDKRwKjQM6zmPfi0A3Mp0CHjHE599OXb-NG2IMH-wmlT0vEZjP2U97hxmsNW1RtHNXWaRKFL9T-WVmZbJf3fH5hXqTv495L3MQfq_m5YFHyc5NuIqK4K4xMJB956a33ICnH8DmvPmJgderNAhqEX1JHUAsR63K7xbZxRBDS8OlQYcEf-_v75X0kT1s067enSvI8Vs212AVnI6k0FmgQNM8DfJUq6YduD0m2F2ZWpKPrwdd6PdW5ZlZTEv-D8dYIEQ_CwOWohNoENATmTqxDpPBxK5c723MEt8S7Sa9MEGAo56HW3-9pbazbEdY1GqPWKVkov7K_6eBFcWsV67AgJpoKFt6RiBfRvokgiH96WG89qBB_Ucpm8uBahX93FaOXhVLW0VjJH2LQKrGw0bb5LS8Ql5o'
        }
    },
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    encrypted: true
});
