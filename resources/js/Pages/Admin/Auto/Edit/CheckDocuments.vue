<template>
    <div>
        <div class="bg-white shadow overflow-hidden sm:rounded-md mt-5">
            <ul>
                <li v-for="(file, index) in $props.editable.files" :key="index">
                    <a class="block hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition duration-150 ease-in-out">
                        <div class="px-4 py-4 sm:px-6">
                            <div class="flex items-center justify-between">
                                <button @click="modal = file"  class="focus:outline-none focus:border-none text-sm leading-5 font-medium text-pink-600 truncate">{{ file }}</button>
                                <div class="ml-2 flex-shrink-0 flex">
                                    <button @click="removeFile(file)" class="focus:outline-none focus:border-none px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-500 text-white">Șterge</button>
                                </div>
                            </div>
                        </div>
                    </a>
                </li>
            </ul>
        </div>

        <dialog-modal :show="modal">
            <template #title>
                 Vizualizarea documentului
            </template>

            <template #content>
                <div class="text-center">
                    <img v-if="modal !== false" :src="'/storage/auto/' + $props.editable.id + '/' + modal" alt="Document Photo" />
                </div>
            </template>

            <template #footer>
                <jet-secondary-button @click.native="modal = false">
                    Închide
                </jet-secondary-button>
            </template>
        </dialog-modal>
    </div>
</template>

<script>
import DialogModal from "@/Jetstream/DialogModal";
import JetSecondaryButton from "@/Jetstream/SecondaryButton";

export default {
    components: {
        DialogModal,
        JetSecondaryButton
    },
    props: ['editable'],
    data() {
        return {
            modal: false,
        }
    },
    methods: {
        removeFile(file) {
            this.$inertia.patch(route('admin.auto.delete-documents', this.$props.editable.id), {
                file: file
            })
        }
    },
}
</script>
