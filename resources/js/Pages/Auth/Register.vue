<script setup>
import {Head, Link, useForm} from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    name: '',
    gender: '',
    date_of_birth: '',
    phone_number: '',
    address: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Register"/>

    <AuthenticationCard>
        <template #logo>
            <AuthenticationCardLogo/>
        </template>

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="name" value="Name"/>
                <TextInput
                    id="name"
                    v-model="form.name"
                    autocomplete="name"
                    autofocus
                    class="mt-1 block w-full"
                    required
                    type="text"
                />
                <InputError :message="form.errors.name" class="mt-2"/>
            </div>

            <div class="mt-4">
                <InputLabel for="gender" value="Jenis Kelamin"/>
                <select v-model="form.gender"
                        class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option disabled value="">Pilih Jenis Kelamin</option>
                    <option>Laki-Laki</option>
                    <option>Perempuan</option>
                </select>
                <InputError :message="form.errors.gender" class="mt-2"/>
            </div>

            <div class="mt-4">
                <InputLabel for="date_of_birth" value="Tanggal Lahir"/>
                <TextInput
                    id="date_of_birth"
                    v-model="form.date_of_birth"
                    autocomplete="date_of_birth"
                    class="mt-1 block w-full"
                    required
                    type="date"
                />
                <InputError :message="form.errors.date_of_birth" class="mt-2"/>
            </div>

            <div class="mt-4">
                <InputLabel for="phone_number" value="Nomor Telpon"/>
                <TextInput
                    id="phone_number"
                    v-model="form.phone_number"
                    autocomplete="phone_number"
                    class="mt-1 block w-full"
                    required
                    type="tel"
                    pattern="[0-9]{4}[0-9]{4}[0-9]{3,4}"
                    placeholder="0812XXXXXXXX"
                />
                <InputError :message="form.errors.phone_number" class="mt-2"/>
            </div>

            <div class="mt-4">
                <InputLabel for="address" value="Alamat"/>
                <TextInput
                    id="address"
                    v-model="form.address"
                    autocomplete="address"
                    autofocus
                    class="mt-1 block w-full"
                    required
                    type="text"
                />
                <InputError :message="form.errors.address" class="mt-2"/>
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="Email"/>
                <TextInput
                    id="email"
                    v-model="form.email"
                    autocomplete="email"
                    class="mt-1 block w-full"
                    required
                    type="email"
                />
                <InputError :message="form.errors.email" class="mt-2"/>
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password"/>
                <TextInput
                    id="password"
                    v-model="form.password"
                    autocomplete="new-password"
                    class="mt-1 block w-full"
                    required
                    type="password"
                />
                <InputError :message="form.errors.password" class="mt-2"/>
            </div>

            <div class="mt-4">
                <InputLabel for="password_confirmation" value="Confirm Password"/>
                <TextInput
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    autocomplete="new-password"
                    class="mt-1 block w-full"
                    required
                    type="password"
                />
                <InputError :message="form.errors.password_confirmation" class="mt-2"/>
            </div>

            <div v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature" class="mt-4">
                <InputLabel for="terms">
                    <div class="flex items-center">
                        <Checkbox id="terms" v-model:checked="form.terms" name="terms" required/>

                        <div class="ms-2">
                            I agree to the <a :href="route('terms.show')" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                              target="_blank">Terms
                            of Service</a> and <a :href="route('policy.show')" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                                  target="_blank">Privacy
                            Policy</a>
                        </div>
                    </div>
                    <InputError :message="form.errors.terms" class="mt-2"/>
                </InputLabel>
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link :href="route('login')"
                      class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Already registered?
                </Link>

                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing" class="ms-4">
                    Register
                </PrimaryButton>
            </div>
        </form>
    </AuthenticationCard>
</template>
