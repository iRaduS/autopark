<script setup>
import { router, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import FormSection from '@/Components/FormSection.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import DangerButton from '@/Components/DangerButton.vue';
import ActionMessage from '@/Components/ActionMessage.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    welcomeInformations: Object,
});

const form = useForm({
    _method: 'PUT',
    image_url: props.welcomeInformations.image_url,
    description: props.welcomeInformations.description,
    message: '',
});

const updateWelcomeEditPageInformation = () => {
    form.post(route('admin.edit-welcome-page.update'), {
        preserveScroll: true,
        errorBag: 'updateWelcomeEditPageInformation',
    });
};

const deleteEntry = (message) => {
    router.delete(route('admin.edit-welcome-page.delete-message'), {
        data: {
            message: message,
        },
        preserveScroll: true,
    });
};
</script>

<template>
    <AppLayout title="Edit Welcome Page">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Admin Panel > Edit Welcome Page
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <FormSection @submitted="updateWelcomeEditPageInformation">
                    <template #title>
                        Edit Welcome Page
                    </template>

                    <template #description>
                        Here you can edit the welcome page informations.
                    </template>

                    <template #form>
                        <div class="col-span-4">
                            <InputLabel for="image_url" value="Image URL" />
                            <TextInput
                                id="image_url"
                                type="text"
                                class="mt-1 block w-full"
                                autocomplete="image_url"
                                v-model="form.image_url"
                            />
                            <InputError :message="null" class="mt-2" />
                        </div>
                        <div class="col-span-2 flex items-end">
                            <a target="_blank" :href="form.image_url" class="inline-flex items-center justify-center px-4 py-3 bg-indigo-600 dark:bg-yellow-600 text-gray-900 dark:text-white border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest">
                                Check image
                            </a>
                        </div>

                        <div class="col-span-6 sm:col-span-4">
                            <InputLabel for="description" value="Description" />
                            <TextInput
                                id="description"
                                type="text"
                                class="mt-1 block w-full"
                                autocomplete="description"
                                v-model="form.description"
                            />
                            <InputError :message="null" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-4">
                            <InputLabel for="message" value="New Message" />
                            <TextInput
                                id="message"
                                type="text"
                                class="mt-1 block w-full"
                                autocomplete="message"
                                v-model="form.message"
                            />
                            <InputError :message="null" class="mt-2" />
                        </div>

                        <div class="col-span-6">
                            <ul role="list" class="divide-y divide-gray-600">
                                <li v-for="message in welcomeInformations.messages" class="flex items-center justify-between gap-x-6 py-5">
                                    <div class="min-w-0">
                                        <div class="flex items-start gap-x-3">
                                            <p class="text-sm font-semibold leading-6 text-gray-900 dark:text-gray-300">{{ message }}</p>
                                        </div>
                                    </div>
                                    <div class="flex flex-none items-center gap-x-4">
                                        <DangerButton @click="deleteEntry(message)">Remove</DangerButton>
                                    </div>
                                </li>
                            </ul>
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
            </div>
        </div>
    </AppLayout>
</template>
