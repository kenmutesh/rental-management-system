// globalComponents.js

import { defineAsyncComponent } from 'vue';

export default function registerGlobalComponents(app) {
    app.component('app-spinner', defineAsyncComponent(() => import('../Components/Spinner.vue')));
    // app.component('AnotherComponent', defineAsyncComponent(() => import('./Components/AnotherComponent.vue')));
}
