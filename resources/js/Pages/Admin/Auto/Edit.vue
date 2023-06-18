<template>
    <app-layout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <edit-itp-date :editable="$props.auto"></edit-itp-date>
                <jet-section-border />
                <edit-insurance-date :editable="$props.auto"></edit-insurance-date>
                <jet-section-border />

                <jet-section-title>
                    <template #title>
                        Încarcă documentele mașinii
                    </template>

                    <template #description>
                        Aici poți încărca documentele mașinii
                    </template>
                </jet-section-title>
                <upload-documents :editable="$props.auto"></upload-documents>

                <jet-section-border />

                <jet-section-title>
                    <template #title>
                        Verifică documentele mașinii
                    </template>

                    <template #description>
                        Aici poți verifica documentele mașinii
                    </template>
                </jet-section-title>
                <check-documents :editable="$props.auto"></check-documents>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import EditItpDate from "@/Pages/Admin/Auto/Edit/EditItpDate"
import EditInsuranceDate from "@/Pages/Admin/Auto/Edit/EditInsuranceDate"
import JetSectionBorder from "@/Jetstream/SectionBorder"
import UploadDocuments from "@/Pages/Admin/Auto/Edit/UploadDocuments";
import JetSectionTitle from "@/Jetstream/SectionTitle"
import CheckDocuments from "@/Pages/Admin/Auto/Edit/CheckDocuments";

export default {
    components: {EditItpDate, AppLayout, EditInsuranceDate, JetSectionBorder, UploadDocuments, JetSectionTitle, CheckDocuments},
    props: ['auto']
}
</script>
