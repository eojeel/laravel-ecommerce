<script setup>
import profileInput from '@/Components/ProfileInput.vue';
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import { reactive } from 'vue'

const props = defineProps({
    user: Object,
    customer: Object,
    shippingaddress: Object,
    billingaddress: Object,
    countries: Object,
})

const form = useForm({
    first_name: props.customer.first_name,
    last_name: props.customer.last_name,
    email: props.user.email,
    phone: props.customer.phone,
    shipping_address1: props.shippingaddress.address1,
    shipping_address2: props.shippingaddress.address2,
    shipping_city: props.shippingaddress.city,
    shipping_county: props.shippingaddress.county,
    shipping_country_code: props.shippingaddress.country_code,
    shipping_postcode: props.shippingaddress.postcode,
    billing_address1: props.billingaddress.address1,
    billing_address2: props.billingaddress.address2,
    billing_city: props.billingaddress.city,
    billing_county: props.billingaddress.county,
    billing_postcode: props.billingaddress.postcode,
    billing_country_code: props.billingaddress.country_code,
})

const profileForm = useForm({
    old_password : '',
    new_password : '',
    new_password_confirmation : ''
})

function mainsubmit() {
    router.post('/profile', form, {
        errorBag: 'profile',
    })
}

function profilesubmit() {
    router.post('/profile/password', profileForm, {
        errorBag: 'profileForm',
    })
}

</script>

<template>

    <Head title="Profile" />
    <DefaultLayout>
            <div class="container lg:w-2/3 xl:w-2/3 mx-auto">
                <div class="grid grid-cols-1 sm:grid-cols-5 items-start gap-6">
                    <div class="col-span-3 bg-white p-4 rounded-lg shadow">
                        <form @submit.prevent="mainsubmit">
                            <!-- Profile Details -->
                            <div role="alert mb-6" v-if="$page.props.errors.profile">
                                <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                                    Errors!
                                </div>
                                <div
                                    class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                                    <p v-for="error in $page.props.errors.profile" class="input-error mb-4">{{ error }}
                                    </p>
                                </div>
                            </div>
                            <div class="mb-6">
                                <h2 class="text-xl mb-5">Your Profile</h2>
                                <div class="mb-4 grid gap-1 md:grid-cols-2">
                                    <input placeholder="First Name" type="text" name="first_name"
                                        v-model="form.first_name"
                                        class="ml-2 border-gray-300 focus:border-emerald-500 focus:outline-none focus:ring-emerald-500 rounded-md w-half" />
                                    <input placeholder="Last Name" type="text" name="last_name" v-model="form.last_name"
                                        class="ml-2 border-gray-300 focus:border-emerald-500 focus:outline-none focus:ring-emerald-500 rounded-md w-half" />
                                </div>
                                <div class="mb-4">
                                    <input placeholder="Your Email" type="email" name="email" v-model="form.email"
                                        class="border-gray-300 focus:border-emerald-500 focus:outline-none focus:ring-emerald-500 rounded-md w-full" />
                                </div>
                                <div class="mb-4">
                                    <input placeholder="Your Phone" type="text" name="phone" v-model="form.phone"
                                        class="border-gray-300 focus:border-emerald-500 focus:outline-none focus:ring-emerald-500 rounded-md w-full" />
                                </div>
                            </div>
                            <!--/ Profile Details -->

                            <!-- Billing Address -->
                            <div class="mb-6">
                                <h2 class="text-xl mb-5">Billing Address</h2>
                                <div class="flex gap-3">
                                    <div class="mb-4 flex-1">
                                        <input placeholder="Address 1" type="text" name="billing_address1"
                                            v-model="form.billing_address1"
                                            class="border-gray-300 focus:border-emerald-500 focus:outline-none focus:ring-emerald-500 rounded-md w-full" />
                                    </div>
                                    <div class="mb-4 flex-1">
                                        <input placeholder="Address 2" type="text" name="billing_address2"
                                            v-model="form.billing_address2"
                                            class="border-gray-300 focus:border-emerald-500 focus:outline-none focus:ring-emerald-500 rounded-md w-full" />
                                    </div>
                                </div>
                                <div class="flex gap-3">
                                    <div class="mb-4 flex-1">
                                        <input placeholder="City" type="text" name="billing_city"
                                            v-model="form.billing_city"
                                            class="border-gray-300 focus:border-emerald-500 focus:outline-none focus:ring-emerald-500 rounded-md w-full" />
                                    </div>
                                    <div class="mb-4 flex-1">
                                        <input placeholder="County" type="text" name="billing_county"
                                            v-model="form.billing_county"
                                            class="border-gray-300 focus:border-emerald-500 focus:outline-none focus:ring-emerald-500 rounded-md w-full" />
                                    </div>
                                </div>
                                <div class="flex gap-3">
                                    <div class="mb-4 flex-1">
                                        <select type="text" name="billing_country_code"
                                            v-model="form.billing_country_code"
                                            class="border-gray-300 focus:border-emerald-500 focus:outline-none focus:ring-emerald-500 rounded-md w-full">
                                            <option value="">Country</option>
                                            <option v-for="i in countries" :value="i.code"
                                                :selected="form.shipping_country_code == i.code">{{ i.name }}</option>
                                        </select>
                                    </div>
                                    <div class="mb-4 flex-1">
                                        <input placeholder="Postcode" type="text" name="billing_postcode"
                                            v-model="form.billing_postcode"
                                            class="border-gray-300 focus:border-emerald-500 focus:outline-none focus:ring-emerald-500 rounded-md w-full" />
                                    </div>
                                </div>
                            </div>
                            <!--/ Billing Address -->

                            <!-- Shipping Address -->
                            <div class="mb-6">
                                <div class="flex items-center justify-between mb-5">
                                    <h2 class="text-xl">Shipping Address</h2>
                                    <div class="flex items-center">
                                        <input id="sameAsBillingAddress" type="checkbox"
                                            class="mr-3 rounded border-gray-300 text-emerald-500 focus:ring-emerald-500" />
                                        <label for="sameAsBillingAddress">Same as Billing</label>
                                    </div>
                                </div>
                                <div class="flex gap-3">
                                    <div class="mb-4 flex-1">
                                        <input placeholder="Address 1" type="text" name="shipping_address1"
                                            v-model="form.shipping_address1"
                                            class="border-gray-300 focus:border-emerald-500 focus:outline-none focus:ring-emerald-500 rounded-md w-full" />
                                    </div>
                                    <div class="mb-4 flex-1">
                                        <input placeholder="Address 2" type="text" name="shipping_address2"
                                            v-model="form.shipping_address2"
                                            class="border-gray-300 focus:border-emerald-500 focus:outline-none focus:ring-emerald-500 rounded-md w-full" />
                                    </div>
                                </div>
                                <div class="flex gap-3">
                                    <div class="mb-4 flex-1">
                                        <input placeholder="City" type="text" name="shipping_city"
                                            v-model="form.shipping_city"
                                            class="border-gray-300 focus:border-emerald-500 focus:outline-none focus:ring-emerald-500 rounded-md w-full" />
                                    </div>
                                    <div class="mb-4 flex-1">
                                        <input placeholder="County" type="text" name="shipping_country"
                                            v-model="form.shipping_county"
                                            class="border-gray-300 focus:border-emerald-500 focus:outline-none focus:ring-emerald-500 rounded-md w-full" />
                                    </div>
                                </div>
                                <div class="flex gap-3">
                                    <div class="mb-4 flex-1">
                                        <select type="text" name="shipping_country" v-model="form.shipping_country_code"
                                            class="border-gray-300 focus:border-emerald-500 focus:outline-none focus:ring-emerald-500 rounded-md w-full">
                                            <option value="">Country</option>
                                            <option v-for="i in countries" :value="i.code"
                                                :selected="form.billing_country_code == i.code">{{ i.name }}</option>
                                        </select>
                                    </div>
                                    <div class="mb-4 flex-1">
                                        <input placeholder="Postcode" type="text" name="shipping_postcode"
                                            v-model="form.shipping_postcode"
                                            class="border-gray-300 focus:border-emerald-500 focus:outline-none focus:ring-emerald-500 rounded-md w-full" />
                                    </div>
                                </div>
                            </div>
                            <!--/ Shipping Address -->

                            <button type="submit" :disabled="form.processing"
                                class="btn-primary bg-emerald-500 hover:bg-emerald-600 active:bg-emerald-700 w-full">Update</button>
                        </form>
                    </div>

                    <div class="col-span-2 bg-white p-4 rounded-lg shadow">
                        <div role="alert mb-6" v-if="$page.props.errors.profileForm">
                                <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                                    Errors!
                                </div>
                                <div
                                    class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                                    <p v-for="error in $page.props.errors.profileForm" class="input-error mb-4">{{ error }}
                                    </p>
                                </div>
                            </div>
                        <h2 class="text-xl mb-5">Update Password!</h2>
                        <form @submit.prevent="profilesubmit">
                            <div class="mb-4">
                                <input type="password" name="old_password" placeholder="Your Current password"
                                    v-model="profileForm.old_password"
                                    class="border-gray-300 focus:border-emerald-500 focus:outline-none focus:ring-emerald-500 rounded-md w-full" />
                            </div>
                            <div class="mb-4">
                                <input type="password" name="new_password" placeholder="New password"
                                v-model="profileForm.new_password"
                                    class="border-gray-300 focus:border-emerald-500 focus:outline-none focus:ring-emerald-500 rounded-md w-full" />
                            </div>
                            <div class="mb-4">
                                <input type="password" name="new_password_confirmation" placeholder="Repeat new password"
                                    v-model="profileForm.new_password_confirmation"
                                    class="border-gray-300 focus:border-emerald-500 focus:outline-none focus:ring-emerald-500 rounded-md w-full" />
                            </div>
                            <div>
                                <button type="submit"
                                    class="btn-primary bg-emerald-500 hover:bg-emerald-600 active:bg-emerald-700">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </DefaultLayout>
</template>
