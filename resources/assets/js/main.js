import Vue from 'vue'
import router from "./lib/router";
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import lang from 'element-ui/lib/locale/lang/en'
import locale from 'element-ui/lib/locale'
import { DataTables, DataTablesServer } from 'vue-data-tables'
import VueDataTables from 'vue-data-tables'
import VModal from 'vue-js-modal'
Vue.use(DataTables);
Vue.use(DataTablesServer);
Vue.use(VueDataTables);
locale.use(lang);
Vue.use(ElementUI);
Vue.use(BootstrapVue);
Vue.use(IconsPlugin);
Vue.use(VModal)
new Vue({
    el: '#app',
    router,
});
