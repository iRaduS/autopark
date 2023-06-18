<template>
    <jet-action-section>
        <template #title>
            Șterge contul
        </template>

        <template #description>
            Poți șterge permanent contul
        </template>

        <template #content>
            <div class="max-w-xl text-sm text-gray-600">
                Odată ce ștergi contul, toate resursele și datele vor fi permanent șterse. Înainte de șterge contul, te rugăm să descarci orice date sau informații care dorești să le salvezi.
            </div>

            <div class="mt-5">
                <jet-danger-button @click.native="confirmUserDeletion">
                    Șterge contul
                </jet-danger-button>
            </div>

            <!-- Delete Account Confirmation Modal -->
            <jet-dialog-modal :show="confirmingUserDeletion" @close="closeModal">
                <template #title>
                    Șterge contul
                </template>

                <template #content>
                    Ești sigur că vrei să ștergi contul lui {{ $props.editable.name }}? Odată șters, toate resursele vor fi șterse permanent.
                </template>

                <template #footer>
                    <jet-secondary-button @click.native="closeModal">
                        Închide
                    </jet-secondary-button>

                    <jet-danger-button class="ml-2" @click.native="deleteUser">
                        Șterge
                    </jet-danger-button>
                </template>
            </jet-dialog-modal>
        </template>
    </jet-action-section>
</template>

<script>
import JetActionSection from '@/Jetstream/ActionSection'
import JetDialogModal from '@/Jetstream/DialogModal'
import JetDangerButton from '@/Jetstream/DangerButton'
import JetSecondaryButton from '@/Jetstream/SecondaryButton'

export default {
    components: {
        JetActionSection,
        JetDangerButton,
        JetDialogModal,
        JetSecondaryButton,
    },

    data() {
        return {
            confirmingUserDeletion: false,
        }
    },

    props: ['editable'],

    methods: {
        confirmUserDeletion() {
            this.confirmingUserDeletion = true;
        },

        deleteUser() {
            this.$inertia.delete(route('admin.user.force', this.$props.editable.id))
        },

        closeModal() {
            this.confirmingUserDeletion = false
        },
    },
}
</script>
