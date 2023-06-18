<template>
    <app-layout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div v-if="$page.props.user.check['create user']">
                    <jet-form-section @submitted="updateUser">
                        <template #title>
                            Introdu datele utilizatorului
                        </template>

                        <template #description>
                            Aici poți introduce diverse date despre utilizator cum ar fi adresa de e-mail, numele, funcția deținută, etc...
                        </template>

                        <template #form>
                            <!-- Name -->
                            <div class="col-span-6 sm:col-span-4">
                                <jet-label for="name" value="Nume complet" />
                                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" autocomplete="name" />
                                <jet-input-error :message="form.errors.name" class="mt-2" />
                            </div>

                            <!-- Email -->
                            <div class="col-span-6 sm:col-span-4">
                                <jet-label for="email" value="Adresa de email" />
                                <jet-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" />
                                <jet-input-error :message="form.errors.email" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <jet-label for="title" value="Funcția deținută" />
                                <jet-input id="title" type="text" class="mt-1 block w-full" v-model="form.title" autocomplete="title" />
                                <jet-input-error :message="form.errors.title" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <jet-label for="password" value="Parolă" />
                                <jet-input id="password" type="password" class="mt-1 block w-full" v-model="form.password" autocomplete="title" />
                                <jet-input-error :message="form.errors.password" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <jet-label for="password_confirmation" value="Confirmare parolă" />
                                <jet-input id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" autocomplete="title" />
                                <jet-input-error :message="form.errors.password_confirmation" class="mt-2" />
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
                </div>
                <flash-message />
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
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
                                            Rolul
                                        </th>
                                        <th v-if="$page.props.user.check['edit user'] || $page.props.user.check['edit status']" scope="col" class="relative px-6 py-3">
                                            <span class="sr-only">Opțiuni</span>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <tr v-for="user in $page.props.users.data">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        <img class="h-10 w-10 rounded-full" :src="user.profile_photo_url" alt="">
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">{{ user.name }}</div>
                                                        <div class="text-sm text-gray-500">{{ user.email }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ user.title }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span v-if="user.deleted_at" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">DEZACTIVAT</span>
                                                <span v-else class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">ACTIV</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ user.roles[0].name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <inertia-link  v-if="$page.props.user.check['edit user']" :href="route('admin.user.edit', user.id)" class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:border-green-700 focus:shadow-outline-indigo active:bg-indigo-600 transition ease-in-out duration-150"><i class="fas fa-edit"></i> Editează</inertia-link>
                                                <div class="inline-flex" v-if="$page.props.user.check['edit status']">
                                                    <button v-if="user.deleted_at" @click="activateUser(user.id)" class="inline-flex items-center justify-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green active:bg-green-600 transition ease-in-out duration-150"><i class="fas fa-check-circle"></i> Activează</button>
                                                    <jet-danger-button v-else @click.native="confirmUserDeactivation(user.name, user.id)"><i class="fas fa-times-circle"></i> Dezactivează</jet-danger-button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <pagination :links="$page.props.users.links" />
            </div>
        </div>


        <jet-dialog-modal :show="confirmingUserDeactivation" @close="closeModal">
            <template #title>
                Dezactivează contul
            </template>

            <template #content>
                Ești sigur că vrei să dezactivezi contul {{ $data.deactivationName }} (ID: {{ $data.deactivationId }})?
            </template>

            <template #footer>
                <jet-secondary-button @click.native="closeModal">
                    Închide
                </jet-secondary-button>

                <jet-danger-button @click.native="deactivateUser($data.deactivationId)">
                    Dezactivează
                </jet-danger-button>
            </template>
        </jet-dialog-modal>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import Pagination from "@/Jetstream/Pagination";
import JetDialogModal from "@/Jetstream/DialogModal"
import JetSecondaryButton from "@/Jetstream/SecondaryButton"
import JetDangerButton from "@/Jetstream/DangerButton"
import JetSectionBorder from"@/Jetstream/SectionBorder"
import JetFormSection from "@/Jetstream/FormSection"
import JetLabel from "@/Jetstream/Label"
import JetInput from "@/Jetstream/Input"
import JetInputError from "@/Jetstream/InputError"
import JetActionMessage from "@/Jetstream/ActionMessage"
import JetButton from "@/Jetstream/Button"
import FlashMessage from "@/Jetstream/FlashMessage"

export default {
    components: {
        Pagination,
        AppLayout,
        JetDialogModal,
        JetSecondaryButton,
        JetDangerButton,
        JetSectionBorder,
        JetFormSection,
        JetLabel,
        JetInput,
        JetInputError,
        JetActionMessage,
        JetButton,
        FlashMessage
    },

    data() {
        return {
            confirmingUserDeactivation: false,
            deactivationName: '',
            deactivationId: null,
            form: this.$inertia.form({
                name: '',
                email: '',
                title: '',
                password: '',
                password_confirmation: ''
            })
        }
    },

    methods: {
        confirmUserDeactivation(deactivationName, deactivationId) {
            this.confirmingUserDeactivation = true
            this.deactivationName = deactivationName
            this.deactivationId = deactivationId
        },
        closeModal() {
            this.confirmingUserDeactivation = false
            this.deactivationName = ''
            this.deactivationId = null
        },
        deactivateUser(deactivationId) {
            this.$inertia.delete(this.route('admin.user.delete', {
                user: deactivationId
            }))
            this.closeModal()
        },
        activateUser(activationId) {
            this.$inertia.patch(this.route('admin.user.restore', activationId))
        },
        updateUser() {
            this.form.post(route('admin.users.store'), {
                errorsBag: 'updateUser',
                preserveScroll: true,
                onFinish: () => this.form.reset(),
            })
        }
    }
}
</script>
