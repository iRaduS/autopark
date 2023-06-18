<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { router, useForm } from "@inertiajs/vue3";
import Pagination from "@/Components/Pagination.vue";
import DangerButton from "@/Components/DangerButton.vue";

const props = defineProps({
    ticket: Object,
    comments: Object,
})

const form = useForm({
   'content': '',
});

const sendFormCreateComment = (ticket) => {
    form.post(route('tickets.comments.create', { ticket: ticket.id }), {
        preserveScroll: true,
        errorBag: 'createNewSupportTicket',
        onSuccess: () => form.reset(),
    });
}

const deleteComment = (comment) => {
    router.delete(route('tickets.comments.delete', { ticketComment: comment.id }), {
        preserveScroll: true,
    });
}

const closeTicket = (ticket) => {
    router.patch(route('tickets.status', { ticket: ticket.id }), {
        preserveScroll: true,
    });
}
</script>

<template>
    <AppLayout title="Tickets">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Ticket {{ props.ticket.id }}
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div>
                    <div class="px-4 sm:px-0">
                        <h3 class="text-base font-semibold leading-7 text-white">Ticket Information</h3>
                        <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-400">Personal details and ticket.</p>
                        <DangerButton @click="closeTicket(props.ticket)" :class="props.ticket.status ? 'bg-green-500 hover:bg-green-300 focus:ring-green-500 active:bg-green-500' : 'bg-red-500'">
                            {{ props.ticket.status ? 'Open this ticket' : 'Close this ticket' }}
                        </DangerButton>
                    </div>
                    <div class="mt-6 border-t border-white/10">
                        <dl class="divide-y divide-white/10">
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-white">Full name</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-400 sm:col-span-2 sm:mt-0">{{ props.ticket.user.name }}</dd>
                            </div>
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-white">Email address</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-400 sm:col-span-2 sm:mt-0">{{ props.ticket.user.email }}</dd>
                            </div>
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-white">Priority</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-400 sm:col-span-2 sm:mt-0">{{ props.ticket.priority }}</dd>
                            </div>
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-white">Problem</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-400 sm:col-span-2 sm:mt-0">{{ props.ticket.problem }}</dd>
                            </div>
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-white">Detailed problem</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-400 sm:col-span-2 sm:mt-0">{{ props.ticket.detailed_problem }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <div class="overflow-hidden rounded-lg shadow my-5 bg-gray-800" v-if="! props.ticket.status">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full object-cover" :src="$page.props.auth.user.profile_photo_url" :alt="$page.props.auth.user.name">
                            </div>
                            <div class="min-w-0 flex-1">
                                <form @submit.prevent="sendFormCreateComment(props.ticket)" class="relative">
                                    <div class="overflow-hidden rounded-lg shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-indigo-600">
                                        <label for="content" class="sr-only">Add your comment</label>
                                        <textarea v-model="form.content" rows="3" name="content" id="content" class="block w-full resize-none border-0 bg-transparent py-1.5 dark:text-white text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" placeholder="Add your comment..." />

                                        <div class="py-2" aria-hidden="true">
                                            <div class="py-px">
                                                <div class="h-9" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="absolute inset-x-0 bottom-0 flex justify-between py-2 pl-3 pr-2">
                                        <div class="flex items-center space-x-5">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0">
                                                    <button type="submit" class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Post</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden rounded-lg shadow my-5 bg-gray-800" v-for="comment in props.comments.data">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="sm:flex items-center justify-between">
                            <div class="mb-4 flex-shrink-0 sm:mb-0 sm:mr-4 flex">
                                <img class="h-11 border border-gray-300 bg-white text-gray-300 sm:w-11 rounded-full object-cover" :src="comment.user.profile_photo_url" :alt="comment.user.name">
                                <div class="mx-5">
                                    <h4 class="text-lg font-bold dark:text-white">
                                        {{ comment.user.name }}
                                        <span class="text-sm font-normal text-gray-500">posted at {{ new Date(comment.created_at).toLocaleString() }}</span>
                                    </h4>
                                    <p class="mt-1 dark:text-gray-300">{{ comment.content }}</p>
                                </div>
                            </div>
                            <div class="text-right" v-if="comment.user.id === $page.props.auth.user.id && ! props.ticket.status">
                                <DangerButton @click="deleteComment(comment)">Delete</DangerButton>
                            </div>
                        </div>
                    </div>
                </div>
                <Pagination :links="props.comments.links" />
            </div>
        </div>
    </AppLayout>
</template>
