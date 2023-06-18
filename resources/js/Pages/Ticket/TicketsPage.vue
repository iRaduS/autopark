<script setup>
import { Link, router, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import FormSection from '@/Components/FormSection.vue';
import ActionMessage from '@/Components/ActionMessage.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import DangerButton from "@/Components/DangerButton.vue";
import Pagination from "@/Components/Pagination.vue";

const props = defineProps({
   tickets: Object,
});

const form = useForm({
    detailed_problem: '',
    priority: 'NORMAL',
    problem: 'ACCOUNT',
});

const createNewSupportTicket = () => {
    form.post(route('tickets.create'), {
        preserveScroll: true,
        errorBag: 'createNewSupportTicket',
        onSuccess: () => form.reset(),
    });
};

const deleteTicket = (ticket) => {
    router.delete(route('ticket.delete', { ticket: ticket.id }), {
        preserveScroll: true,
    });
}
</script>

<template>
    <AppLayout title="Tickets">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Tickets
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <FormSection @submitted="createNewSupportTicket">
                    <template #title>
                        Create new ticket
                    </template>

                    <template #description>
                        Here you can add new support ticket.
                    </template>

                    <template #form>
                        <div class="col-span-6 sm:col-span-4">
                            <InputLabel for="problem" value="Select issue category" />
                            <select v-model="form.problem" id="problem" name="problem" autocomplete="problem" class="relative block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option selected value="ACCOUNT">Account related problems (lost account, problems with authenticator...)</option>
                                <option value="TECHNIC">Technical related problems (platform bugs, problems with the platform...)</option>
                                <option value="OTHER">Other related problems</option>
                            </select>
                            <InputError :message="form.errors.problem" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <InputLabel for="priority" value="Priority" />
                            <select v-model="form.priority" id="priority" name="priority" autocomplete="priority" class="relative block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option selected value="NORMAL">Normal</option>
                                <option value="URGENT">Urgent</option>
                            </select>
                            <InputError :message="form.errors.priority" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <InputLabel for="description" value="Description" />
                            <TextInput
                                id="description"
                                type="text"
                                class="mt-1 block w-full"
                                autocomplete="description"
                                v-model="form.detailed_problem"
                            />
                            <InputError :message="form.errors.detailed_problem" class="mt-2" />
                        </div>
                    </template>

                    <template #actions>
                        <ActionMessage :on="form.recentlySuccessful" class="mr-3">
                            Saved.
                        </ActionMessage>

                        <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Save
                        </PrimaryButton>
                    </template>
                </FormSection>
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="mt-8 flow-root">
                        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-300" v-if="props.tickets.data.length">
                                        <thead class="bg-indigo-600 dark:bg-gray-800 dark:text-gray-200 text-white">
                                        <tr>
                                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold">Name</th>
                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold">Type</th>
                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold">Priority</th>
                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold">Status</th>
                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold">Created at</th>
                                            <th scope="col" class="relative py-3.5 pl-3 pr-4">
                                                <span class="sr-only">Actions</span>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200 bg-white">
                                        <tr v-for="ticket in props.tickets.data" :key="ticket.id">
                                            <td class="whitespace-nowrap py-5 pl-4 pr-3 text-sm">
                                                <div class="flex items-center">
                                                    <div class="h-11 w-11 flex-shrink-0">
                                                        <img class="h-11 w-11 rounded-full object-cover" :src="ticket.user.profile_photo_url" :alt="ticket.user.name">
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="font-medium text-gray-900">{{ ticket.user.name }}</div>
                                                        <div class="mt-1 text-gray-500">{{ ticket.user.email }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">
                                                <div class="text-gray-900 font-semibold">{{ ticket.problem }}</div>
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">{{ ticket.priority }}</td>
                                            <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">
                                                <span v-if="ticket.status" class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/20">Closed</span>
                                                <span v-else class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Open</span>
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">{{ new Date(ticket.created_at).toLocaleString() }}</td>
                                            <td class="relative whitespace-nowrap py-5 pl-3 pr-4 text-right text-sm font-medium">
                                                <Link :href="route('ticket.show', { ticket: ticket.id })" class="text-indigo-600 hover:text-indigo-900 mr-1">
                                                    See more
                                                </Link>
                                                <DangerButton @click="deleteTicket(ticket)" class="ml-1">
                                                    Delete
                                                </DangerButton>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <div class="bg-red-600/50 py-2.5 text-center text-gray-900 dark:text-gray-200" v-else>
                                        No tickets were found in the database.
                                    </div>
                                    <Pagination  :links="props.tickets.links" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
