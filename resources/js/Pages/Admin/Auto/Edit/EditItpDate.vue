<template>
    <jet-form-section @submitted="uploadItpDate">
        <template #title>
            Introdu data ITP-ului
        </template>

        <template #description>
            Aici poți introduce data ITP-ului, ultima verificare a acestuia pentru o mai bună evidență.
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="date_itp_begin" value="Dată eliberare ITP" />
                <jet-input id="date_itp_begin" type="date" class="mt-1 block w-full" v-model="form.date_itp_begin" autocomplete="date_itp_begin" />
                <jet-input-error :message="form.errors.date_itp_begin" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <jet-label for="date_itp_end" value="Dată scadență ITP" />
                <jet-input id="date_itp_end" type="date" class="mt-1 block w-full" v-model="form.date_itp_end" autocomplete="date_itp_end" />
                <jet-input-error :message="form.errors.date_itp_end" class="mt-2" />
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
                _method: 'PATCH',
                date_itp_begin: this.$props.editable.date_itp_begin,
                date_itp_end: this.$props.editable.date_itp_end
            })
        }
    },
    methods: {
        uploadItpDate() {
            this.form.patch(route('admin.auto.update-itp', this.$props.editable.id))
        }
    }
}
</script>
