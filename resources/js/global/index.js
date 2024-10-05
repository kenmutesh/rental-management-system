// globalComponents.js

import { defineAsyncComponent } from 'vue';

export default function registerGlobalComponents(app) {
    app.component('app-spinner', defineAsyncComponent(() => import('../Widgets/Spinner.vue')));
    app.component('app-card', defineAsyncComponent(() => import('../Widgets/Card.vue')));
}
