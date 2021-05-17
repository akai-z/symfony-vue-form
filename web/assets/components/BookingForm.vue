<template>
    <form @submit.prevent="submit" name="booking" method="post" action="#">
        <div id="booking">
            <div class="form-group">
                <label class="control-label" for="booking_customerName">Customer Name</label>
                <input type="text" id="booking_customerName" name="booking[customerName]" class="form-control" :class="{ 'is-invalid': isSubmitted && $v.form.customerName.$error }" v-model="form.customerName">
                <div v-if="isSubmitted && !$v.form.customerName.required" class="invalid-feedback">Customer name is required</div>
                <div v-if="isSubmitted && !$v.form.customerName.serverError" class="invalid-feedback">{{ serverError.customerName }}</div>
            </div>

            <div class="form-group">
                <label class="control-label" for="booking_mobile">UK Mobile</label>
                <input type="text" id="booking_mobile" name="booking[mobile]" class="form-control" :class="{ 'is-invalid': isSubmitted && $v.form.mobile.$error }" v-model="form.mobile">
                <div v-if="isSubmitted && !$v.form.mobile.required" class="invalid-feedback">Mobile is required</div>
                <div v-if="isSubmitted && !$v.form.mobile.ukmobile" class="invalid-feedback">Invalid mobile number</div>
                <div v-if="isSubmitted && !$v.form.mobile.serverError" class="invalid-feedback">{{ serverError.mobile }}</div>
            </div>

            <div class="form-group">
                <label class="control-label" for="booking_dateOfArrival">Date of Arrival</label>
                <datetime input-id="booking_dateOfArrival" name="booking[dateOfArrival]" class="form-control" input-class="form-control" style="padding: 0" input-style="background-color: transparent; border-color: RGBA(255, 255, 255, 0); height: 37px" :class="{ 'is-invalid': isSubmitted && $v.form.dateOfArrival.$error }" type="datetime" use12-hour v-model="form.dateOfArrival"></datetime>
                <div v-if="isSubmitted && !$v.form.dateOfArrival.required" class="invalid-feedback">Date of arrival is required</div>
                <div v-if="isSubmitted && !$v.form.dateOfArrival.serverError" class="invalid-feedback">{{ serverError.dateOfArrival }}</div>
            </div>

            <div class="form-group">
                <label class="control-label" for="booking_airportName">Airport Name</label>
                <select id="booking_airportName" name="booking[airportName]" class="form-control" :class="{ 'is-invalid': isSubmitted && $v.form.airportName.$error }" v-model="form.airportName">
                    <option :value="airport.value" v-for="(airport) in airportsData.airports" :key="airport.value" :disabled="airport.disabled">{{airport.label}}</option>
                </select>
                <div v-if="isSubmitted && !$v.form.airportName.required" class="invalid-feedback">Airport name is required</div>
                <div v-if="isSubmitted && !$v.form.airportName.serverError" class="invalid-feedback">{{ serverError.airportName }}</div>
            </div>

            <div class="form-group" v-if="terminalsVisible">
                <label class="control-label" for="booking_airportTerminal">Airport Terminal</label>
                <select id="booking_airportTerminal" name="booking[airportTerminal]" class="form-control" :class="{ 'is-invalid': isSubmitted && $v.form.airportTerminal.$error }" v-model="form.airportTerminal">
                    <option :value="terminal.value" v-for="(terminal) in terminalOptions" :key="terminal.value" :disabled="terminal.disabled">{{terminal.label}}</option>
                </select>
                <div v-if="isSubmitted && !$v.form.airportTerminal.requied" class="invalid-feedback">Airport terminal is required</div>
                <div v-if="isSubmitted && !$v.form.airportTerminal.serverError" class="invalid-feedback">{{ serverError.airportTerminal }}</div>
            </div>

            <div class="form-group">
                <label class="control-label" for="booking_airflightNumber">Airflight Number</label>
                <input type="text" id="booking_airflightNumber" name="booking[airflightNumber]" class="form-control" :class="{ 'is-invalid': isSubmitted && $v.form.airflightNumber.$error }" v-model="form.airflightNumber">
                <div v-if="isSubmitted && !$v.form.airflightNumber.required" class="invalid-feedback">Airflight number is required</div>
                <div v-if="isSubmitted && $v.form.airflightNumber.required && !$v.form.airflightNumber.airlinecode" class="invalid-feedback">Invalid airflight number</div>
                <div v-if="isSubmitted && !$v.form.airflightNumber.serverError" class="invalid-feedback">{{ serverError.airflightNumber }}</div>
            </div>

            <div class="form-group">
                <button class="btn btn-primary" type="submit">Submit</button>
            </div>

            <v-dialog />
        </div>
    </form>
</template>

<script>
import { required, requiredIf, helpers } from 'vuelidate/lib/validators'
import axios from 'axios'
import airportsData from '../js/airports-data'

// https://regexlib.com/(X(1)A(4gXc20GThkvez8o3QlDYbmkwLNb87fdJUFS1r4_O3taz2ET5Fz6SmJVYVrVpPfloGGV33E3dzaO6cYVI_5VBP_w1WaKEkWRT7U7GRqyRoz86BliySp6bzCGNPRYKdTLNdnm5hcynoualneipivnm0g_xCNTvedyt23ne2jd2BZrFGDcOIqMem87Cud9Qn2o70))/REDetails.aspx?regexp_id=592
// (This validation RegExp might be outdated for some of the mobile numbers currently used in the UK.)
const ukmobile = helpers.regex('ukmobile', /^(\+44\s?7\d{3}|\(?07\d{3}\)?)\s?\d{3}\s?\d{3}$/)

// https://academe.co.uk/2014/01/validating-flight-codes/
const airlinecode = helpers.regex('airlinecode', /^([a-z][a-z]|[a-z][0-9]|[0-9][a-z])[a-z]?[0-9]{1,4}[a-z]?$/)

export default {
    computed: {
        terminalOptions() {
            return airportsData.terminals[this.form.airportName]
        },
        terminalsVisible() {
            return this.form.airportName in airportsData.terminals
        }
    },
    data () {
        return {
            form: {
                customerName: '',
                mobile: '',
                dateOfArrival: '',
                airportName: '',
                airportTerminal: '',
                airflightNumber: ''
            },
            serverError: {
                airflightNumber: ''
            },
            airportsData,
            isSubmitted: false
        }
    },
    validations: {
        form: {
            customerName: {
                required,
                serverError: function() {
                    return !this.hasServerError('customerName')
                }
            },
            mobile: {
                required,
                ukmobile,
                serverError: function() {
                    return !this.hasServerError('mobile')
                }
            },
            dateOfArrival: {
                required,
                serverError: function() {
                    return !this.hasServerError('dateOfArrival')
                }
            },
            airportName: {
                required,
                serverError: function() {
                    return !this.hasServerError('airportName')
                }
            },
            airportTerminal: {
                requied: requiredIf(function () {
                    return this.form.airportName in this.airportsData.terminals
                }),
                serverError: function() {
                    return !this.hasServerError('airportTerminal')
                }
            },
            airflightNumber: {
                required,
                airlinecode,
                serverError: function() {
                    return !this.hasServerError('airflightNumber')
                }
            }
        }
    },
    methods:{
        hasServerError: function (field) {
            return field in this.serverError
        },
        submit: async function (e) {
            this.isSubmitted = true
            this.serverError = {}

            this.$v.form.$touch()
            if (this.$v.form.$pending || this.$v.form.$error) return

            try {
                await axios.post('/booking/post', new FormData(e.target))

                this.$modal.show('dialog', {
                    text: '<div>Your booking request has been submitted successfully!</div>',
                    buttons: [{
                        title: 'Close',
                        handler: () => { this.$modal.hide('dialog') }
                    }]
                })
            } catch (error) {
                this.serverError = error.response.data
            }
        }
    }
}
</script>
