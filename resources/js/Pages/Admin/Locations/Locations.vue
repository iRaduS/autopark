<template>
    <app-layout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <flash-message />
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8" v-if="$page.props.user.check['general locations']">
                        <jet-search-filter v-model="searchForm.search" class="my-2" @reset="reset" />
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Numele locației
                                    </th>
                                    <th>
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="location in $page.props.locations.data">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ location.name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div v-if="$page.props.user.check['delete location']">
                                            <jet-danger-button @click.native="removeLocation(location.id)"><i class="fas fa-times-circle"></i> Șterge</jet-danger-button>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <pagination :links="$props.locations.links" />
                <jet-section-border />
                <div v-if="$page.props.user.check['create location']">
                    <jet-form-section @submitted="createLocation">
                        <template #title>
                            Introdu datele locației
                        </template>

                        <template #description>
                            Aici poți crea o nouă locație
                        </template>

                        <template #form>
                            <div class="col-span-6 sm:col-span-4">
                                <jet-label for="name" value="Numele locației" />
                                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" autocomplete="name" />
                                <jet-input-error :message="form.errors.name" class="mt-2" />
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
import FlashMessage from "@/Jetstream/FlashMessage";
import JetSectionBorder from "@/Jetstream/SectionBorder";
import JetFormSection from "@/Jetstream/FormSection";
import JetLabel from "@/Jetstream/Label";
import JetInput from "@/Jetstream/Input";
import JetInputError from "@/Jetstream/InputError";
import JetButton from "@/Jetstream/Button";
import JetActionMessage from "@/Jetstream/ActionMessage";
import Pagination from "@/Jetstream/Pagination";
import JetSearchFilter from "@/Jetstream/SearchFilter";
import JetDangerButton from "@/Jetstream/DangerButton";
import mapValues from "lodash/mapValues";
import throttle from "lodash/throttle";
import pickBy from "lodash/pickBy";

export default {
    components: {
        AppLayout,
        FlashMessage,
        JetSectionBorder,
        JetFormSection,
        JetLabel,
        JetInputError,
        JetInput,
        JetButton,
        JetActionMessage,
        Pagination,
        JetSearchFilter,
        JetDangerButton
    },
    props: ['locations', 'filters'],
    data() {
        return {
            form: this.$inertia.form({
                name: ''
            }),
            searchForm: {
                search: this.filters.search
            }
        }
    },
    watch: {
        searchForm: {
            handler: throttle(function() {
                let query = pickBy(this.searchForm)
                this.$inertia.replace(this.route('locations.index', Object.keys(query).length ? query : { remember: 'forget' }))
            }, 150),
            deep: true,
        }
    },
    methods: {
        createLocation() {
            this.form.post(route('locations.store'));
        },
        reset() {
            this.searchForm = mapValues(this.searchForm, () => null)
        },
        removeLocation(locationId) {
            this.$inertia.delete(route('locations.delete', {
                location: locationId
            }))
        }
    }
}
</script>