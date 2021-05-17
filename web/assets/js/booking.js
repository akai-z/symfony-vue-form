import Vue from 'vue'
import Vuelidate from 'vuelidate'
import { Datetime } from 'vue-datetime'
import VModal from 'vue-js-modal'
import BookingForm from '../components/BookingForm.vue'

Vue.use(Vuelidate)
Vue.use(VModal, { dialog: true })
Vue.component('datetime', Datetime)

new Vue({
    el: '#app',
    render: h => h(BookingForm)
})
