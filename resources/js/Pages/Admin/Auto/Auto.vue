<template>
    <app-layout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <flash-message />
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Model și număr de înmatriculare
                                            </th>
                                            <th v-if="$page.props.user.check['edit user'] || $page.props.user.check['edit status']" scope="col" class="relative px-6 py-3">
                                                <span class="sr-only">Opțiuni</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <tr v-for="auto in $page.props.auto.data">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">{{ auto.type }}</div>
                                                        <div class="text-sm text-gray-500">{{ auto.registration_number }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <inertia-link  v-if="$page.props.user.check['edit user']" :href="route('admin.auto.edit', auto.id)" class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:border-green-700 focus:shadow-outline-indigo active:bg-indigo-600 transition ease-in-out duration-150"><i class="fas fa-edit"></i> Editează</inertia-link>

                                                <div class="inline-flex" v-if="$page.props.user.check['edit user']">
                                                    <jet-danger-button @click.native="removeVehicle(auto.id)"><i class="fas fa-times-circle"></i> Șterge</jet-danger-button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <pagination :links="$page.props.auto.links" />
                </div>

                <jet-section-border />
                <div v-if="$page.props.user.check['create user']">
                    <jet-form-section @submitted="createAutovehicle">
                        <template #title>
                            Introdu datele autovehiculului
                        </template>

                        <template #description>
                            Aici poți introduce diverse date despre mașină cum ar fi modelul și numărul de înmatriculare, etc...
                        </template>

                        <template #form>
                            <div class="col-span-6 sm:col-span-4">
                                <jet-label for="last_name" value="Modelul autovehiculului" />
                                <jet-input id="last_name" type="text" class="mt-1 block w-full" v-model="form.type" autocomplete="type" />
                                <jet-input-error :message="form.errors.type" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <jet-label for="first_name" value="Numărul de înmatriculare" />
                                <jet-input id="first_name" type="text" class="mt-1 block w-full" v-model="form.registration_number" autocomplete="first_name" />
                                <jet-input-error :message="form.errors.registration_number" class="mt-2" />
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
                </div>
            </div>
        </div>
    </app-layout>
</template>
<script>
import AppLayout from "@/Layouts/AppLayout";
import JetFormSection from "@/Jetstream/FormSection"
import JetSectionBorder from "@/Jetstream/SectionBorder"
import JetButton from "@/Jetstream/Button"
import JetActionMessage from "@/Jetstream/ActionMessage"
import JetLabel from "@/Jetstream/Label"
import JetInput from "@/Jetstream/Input"
import JetInputError from "@/Jetstream/InputError"
import FlashMessage from "@/Jetstream/FlashMessage"
import Pagination from "@/Jetstream/Pagination"
import JetSecondaryButton from "@/Jetstream/SecondaryButton"
import JetDangerButton from "@/Jetstream/DangerButton"
import JetDialogModal from "@/Jetstream/DialogModal"
import JetSearchFilter from "@/Jetstream/SearchFilter"

export default {
    components: {
        AppLayout,
        JetFormSection,
        JetSectionBorder,
        JetButton,
        JetActionMessage,
        JetLabel,
        JetInput,
        JetInputError,
        FlashMessage,
        Pagination,
        JetSecondaryButton,
        JetDangerButton,
        JetDialogModal,
        JetSearchFilter
    },
    props: ['auto'],
    data() {
        return {
            form: this.$inertia.form({
                type: '',
                registration_number: ''
            })
        }
    },
    methods: {
        createAutovehicle() {
            this.form.post(this.route('admin.auto.store'))
        },
        removeVehicle(autoId) {
            this.$inertia.delete(route('admin.auto.remove', autoId))
        }
    }
}
</script>
