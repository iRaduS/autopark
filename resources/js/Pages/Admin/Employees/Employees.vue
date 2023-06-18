<template>
    <app-layout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <flash-message />
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <jet-search-filter v-model="searchForm.search" class="my-2" @reset="reset" />
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nume
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Funcția deținută
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Data angajării
                                        </th>
                                        <th scope="col" class="relative px-6 py-3">
                                            <span class="sr-only">Opțiuni</span>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <tr v-for="employee in $page.props.employees.data">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">{{ employee.last_name }}</div>
                                                        <div class="text-sm text-gray-500">{{ employee.first_name }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ employee.title }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span v-if="employee.unemployment_date" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">DEZACTIVAT</span>
                                                <span v-else class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">ACTIV</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ employee.employment_date }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                 <div class="inline-flex" v-if="$page.props.user.check['update employee']">
                                                    <button v-if="employee.unemployment_date" @click="activateEmployee(employee.id)" class="inline-flex items-center justify-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green active:bg-green-600 transition ease-in-out duration-150"><i class="fas fa-check-circle"></i> Activează</button>
                                                    <jet-danger-button v-else @click.native="confirmEmployeeDeactivation(`${employee.last_name} ${employee.first_name}`, employee.id)"><i class="fas fa-times-circle"></i> Dezactivează</jet-danger-button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <pagination :links="$props.employees.links" />
                </div>
                <jet-section-border />
                <div v-if="$page.props.user.check['create employee']">
                    <jet-form-section @submitted="createEmployee">
                        <template #title>
                            Introdu datele angajatului
                        </template>

                        <template #description>
                            Aici poți introduce diverse date despre angajat cum ar fi numele prenumele, funcția deținută, etc...
                        </template>

                        <template #form>
                            <div class="col-span-6 sm:col-span-4">
                                <jet-label for="last_name" value="Numele" />
                                <jet-input id="last_name" type="text" class="mt-1 block w-full" v-model="form.last_name" autocomplete="last_name" />
                                <jet-input-error :message="form.errors.last_name" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <jet-label for="first_name" value="Prenumele" />
                                <jet-input id="first_name" type="text" class="mt-1 block w-full" v-model="form.first_name" autocomplete="first_name" />
                                <jet-input-error :message="form.errors.first_name" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <jet-label for="personal_code" value="CNP (Codul Numeric Personal)" />
                                <jet-input id="personal_code" type="text" class="mt-1 block w-full" v-model="form.personal_code" autocomplete="personal_code" />
                                <jet-input-error :message="form.errors.personal_code" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <jet-label for="title" value="Funcția deținută" />
                                <jet-input id="title" type="text" class="mt-1 block w-full" v-model="form.title" autocomplete="title" />
                                <jet-input-error :message="form.errors.title" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <jet-label for="employment_date" value="Data de angajare" />
                                <jet-input id="employment_date" type="date" class="mt-1 block w-full" v-model="form.employment_date" autocomplete="employment_date" />
                                <jet-input-error :message="form.errors.employment_date" class="mt-2" />
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

        <jet-dialog-modal :show="confirmingEmployeeDeactivation" @close="closeModal">
            <template #title>
                 încetare salariat
            </template>

            <template #content>
                Ești sigur că vrei să încetezi contul salariatului <strong>({{ $data.employeeName }} | ID: {{ $data.employeeId }})</strong>?
            </template>

            <template #footer>
                <jet-secondary-button @click.native="closeModal">
                    Închide
                </jet-secondary-button>

                <jet-danger-button @click.native="submitUnemployment($data.employeeId)">
                    Continuă
                </jet-danger-button>
            </template>
        </jet-dialog-modal>
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
import mapValues from "lodash/mapValues"
import throttle from "lodash/throttle"
import pickBy from "lodash/pickBy"
import XLSX from "xlsx"

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
    props: ['employees', 'filters'],
    data() {
        return {
            confirmingEmployeeDeactivation: false,
            employeeName: '',
            employeeId: null,
            form: this.$inertia.form({
                last_name: '',
                first_name: '',
                personal_code: null,
                title: '',
                employment_date: ''
            }),
            inputError: '',
            searchForm: {
                search: this.filters.search
            }
        }
    },
    watch: {
        searchForm: {
            handler: throttle(function() {
                let query = pickBy(this.searchForm)
                this.$inertia.replace(this.route('admin.employee.index', Object.keys(query).length ? query : { remember: 'forget' }))
            }, 150),
            deep: true,
        }
    },
    methods: {
        submitUnemployment(id) {
            this.$inertia.patch(route('admin.employee.deactivate',{ employee: id }))
            this.closeModal()
        },
        activateEmployee(id) {
            this.$inertia.patch(route('admin.employee.reactivate',{ employee: id }))
        },
        confirmEmployeeDeactivation(name, id) {
            this.$data.employeeName = name
            this.$data.employeeId = id
            this.$data.confirmingEmployeeDeactivation = true
        },
        createEmployee() {
            this.form.post(route('admin.employee.store'))
        },
        closeModal() {
            this.$data.confirmingEmployeeDeactivation = false
            this.$data.employeeName = ''
            this.$data.employeeId = null
        },
        reset() {
            this.searchForm = mapValues(this.searchForm, () => null)
        }
    }
}
</script>
