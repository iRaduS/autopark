<template>
    <app-layout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <jet-form-section @submitted="sendDepartureNote">
                    <template #title>
                        Inserează datele pentru fișa de deplasare
                    </template>
                    <template #description>
                        Aici poți introduce selecția pasagerilor care pleacă cu mașinile care aparțin companiei.
                    </template>
                    <template #form>
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="location_id" value="Selectează locația" />
                            <select v-model="form.location_id" id="location_id" class="form-select border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full">
                                <option v-for="location in $props.locations" :value="location.id">{{ location.name }}</option>
                            </select>
                            <jet-input-error :message="form.errors.location_id" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="automobile_id" value="Selectează automobilul" />
                            <select v-model="form.automobile_id" id="automobile_id" class="form-select border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full">
                                <option v-for="automobile in $props.automobiles" :value="automobile.id">{{ automobile.type }} - {{ automobile.registration_number }}</option>
                            </select>
                            <jet-input-error :message="form.errors.automobile_id" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="date" value="Dată deplasare" />
                            <jet-input id="date" type="date" class="mt-1 block w-full" v-model="form.date" autocomplete="date" />
                            <jet-input-error :message="form.errors.date" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="driver" value="Selectează șofer" />
                            <select v-model="form.driver_id" id="driver" class="form-select border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full">
                                <option v-for="employee in $props.employees" :value="employee.id">{{ employee.name }}</option>
                            </select>
                            <jet-input-error :message="form.errors.driver_id" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-4" v-for="index in 7" :key="index">
                            <jet-label :for="`pass_${index}`" :value="`Selectează pasager ${index}`" />
                            <select v-model="form.pass[index - 1]" :id="`pass_${index}`" class="form-select border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full">
                                <option v-for="employee in $props.employees" :value="employee.id">{{ employee.name }}</option>
                            </select>
                            <jet-input-error :message="form.errors.driver_id" class="mt-2" />
                        </div>
                    </template>
                    <template #actions>
                        <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                            Salvat.
                        </jet-action-message>

                        <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Salvează
                        </jet-button>
                    </template>
                </jet-form-section>

                <jet-section-border />

                <div class="bg-white shadow overflow-hidden sm:rounded-md mt-5">
                    <ul>
                        <li v-for="(ticket, index) in $props.tickets.data" :key="index">
                            <a class="block hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition duration-150 ease-in-out">
                                <div class="px-4 py-4 sm:px-6">
                                    <div class="flex items-center justify-between">
                                        <a :href="route('admin.departure.download', { ticket: ticket.id })" class="focus:outline-none focus:border-none text-sm leading-5 font-medium text-pink-600 truncate">
                                            Deplasare către {{ ticket.location.name }}
                                            <div class="text-gray-300 my-1">
                                                <div class="block font-medium text-sm text-gray-700">
                                                    <div class="flex">
                                                        <strong>Dată eliberare fișă de deplasare</strong>
                                                        <div class="ml-1 text-sm leading-5 font-medium text-pink-600">{{ ticket.create_date }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>

                                        <div class="ml-2 flex-shrink-0 flex">
                                            <button @click="removeTicket(ticket)" class="ml-1 focus:outline-none focus:border-none px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-500 text-white">Șterge</button>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>

                <pagination :links="$props.tickets.links" />
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import JetFormSection from "@/Jetstream/FormSection";
import JetButton from "@/Jetstream/Button";
import JetActionMessage from "@/Jetstream/ActionMessage";
import JetLabel from "@/Jetstream/Label";
import JetInputError from "@/Jetstream/InputError";
import JetInput from "@/Jetstream/Input";
import JetSectionBorder from "@/Jetstream/SectionBorder";
import Pagination from "@/Jetstream/Pagination";

export default {
    components: {
        AppLayout,
        JetFormSection,
        JetButton,
        JetActionMessage,
        JetLabel,
        JetInputError,
        JetInput,
        JetSectionBorder,
        Pagination
    },
    props: ['locations', 'automobiles', 'employees', 'tickets'],
    data() {
        return {
            form: this.$inertia.form({
                location_id: this.$props.locations[0].id,
                automobile_id: this.$props.automobiles[0].id,
                driver_id: this.$props.employees[0].id,
                date: '',
                pass: [],
            })
        }
    },
    methods: {
        sendDepartureNote() {
            this.form.post(route('admin.departure.store'))
        },
        removeTicket(ticket) {
            this.$inertia.delete(route('admin.departure.delete', { ticket: ticket.id }))
        },
        downloadTicket(ticket) {
            this.$inertia.get(route('admin.departure.download', { ticket: ticket.id }))
        }
    }
}
</script>