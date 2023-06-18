<template>
    <jet-form-section @submitted="updateProfileInformation">
        <template #title>
            Actualizează datele utilizatorului
        </template>

        <template #description>
            Aici poți actualiza diverse date despre utilizator cum ar fi adresa de e-mail, numele, funcția deținută, etc...
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
</template>

<script>
import JetFormSection from "@/Jetstream/FormSection"
import JetActionMessage from "@/Jetstream/ActionMessage"
import JetLabel from "@/Jetstream/Label"
import JetInput from "@/Jetstream/Input"
import JetButton from "@/Jetstream/Button"
import JetInputError from "@/Jetstream/InputError"

export default {
    components: {
        JetFormSection,
        JetActionMessage,
        JetLabel,
        JetInput,
        JetButton,
        JetInputError
    },
    props: ['editable'],
    data() {
        return {
            form: this.$inertia.form({
                _method: 'PUT',
                name: this.$props.editable.name,
                email: this.$props.editable.email,
                title: this.$props.editable.title
            }),
        }
    },
    methods: {
        updateProfileInformation() {
            this.form.put(route('admin.user.update', this.$props.editable.id), {
                errorBag: 'updateProfileInformation',
                preserveScroll: true
            });
        }
    }
}
</script>
