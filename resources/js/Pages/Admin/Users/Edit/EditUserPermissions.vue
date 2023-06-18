<template>
    <jet-form-section @submitted="updateUserRoles">
        <template #title>
            Editează permisiunile
        </template>

        <template #description>
            Aici vei putea edita toate permisiunile unui utilizator.
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="role" value="Rolul" />
                <select id="role" v-model="form.role" class="form-select border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full">
                    <option value="Basic">Basic</option>
                    <option value="Administrator">Administrator</option>
                </select>
                <jet-input-error :message="form.errors.role" class="mt-2" />
            </div>


            <div class="col-span-6 sm:col-span-4">
                <div v-if="form.role === 'Basic'">
                    <jet-label for="perms" value="Management de permisiuni" />
                    <select v-model="form.perms" id="perms" class="form-multiselect border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full" multiple>
                        <option v-for="permission in Object.keys($props.editable.check)" :value="permission"> {{ permission }} </option>
                    </select>
                </div>
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
import JetButton from "@/Jetstream/Button"
import JetLabel from "@/Jetstream/Label"
import JetInputError from "@/Jetstream/InputError"

export default {
    components: {
        JetFormSection,
        JetActionMessage,
        JetButton,
        JetLabel,
        JetInputError
    },

    props: ['editable'],

    data() {
        return {
            form: this.$inertia.form({
                _method: 'PATCH',
                role: this.$props.editable.roles[0].name,
                perms: []
            })
        }
    },

    mounted() {
        this.$data.form.perms = []
        for (const [name, value] of Object.entries(this.$props.editable.check)) {
            if (!value) continue
            this.$data.form.perms.push(name)
        }
        return this.$data.form.perms
    },

    methods: {
        updateUserRoles() {
            this.form.patch(route('admin.user.roles', this.$props.editable.id), {
                errorBag: 'updateUserRoles',
                preserveScroll: true
            });
        }
    }
}
</script>
