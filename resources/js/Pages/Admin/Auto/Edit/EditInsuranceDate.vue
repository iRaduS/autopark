<template>
    <jet-form-section @submitted="uploadInsuranceDate">
        <template #title>
            Introdu data Asigurării
        </template>

        <template #description>
            Aici poți introduce data Asigurării, pentru o mai bună evidență.
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="date_insurance_begin" value="Dată eliberare Asigurare" />
                <jet-input id="date_insurance_begin" type="date" class="mt-1 block w-full" v-model="form.date_insurance_begin" autocomplete="date_insurance_begin" />
                <jet-input-error :message="form.errors.date_insurance_begin" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <jet-label for="date_insurance_end" value="Dată scadență Asigurare" />
                <jet-input id="date_insurance_end" type="date" class="mt-1 block w-full" v-model="form.date_insurance_end" autocomplete="date_insurance_end" />
                <jet-input-error :message="form.errors.date_insurance_end" class="mt-2" />
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
                date_insurance_begin: this.$props.editable.date_insurance_begin,
                date_insurance_end: this.$props.editable.date_insurance_end
            })
        }
    },
    methods: {
        uploadInsuranceDate() {
            this.form.patch(route('admin.auto.update-insurance', $props.editable.id))
        }
    }
}
</script>
