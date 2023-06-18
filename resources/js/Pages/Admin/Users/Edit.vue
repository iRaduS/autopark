<template>
    <app-layout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <edit-user-information :editable="$props.editable" />
                <div v-if="$page.props.user.check['edit role']">
                    <jet-section-border />
                    <edit-user-permissions :editable="$props.editable" />
                </div>

                <div v-if="$page.props.user.check['delete user']">
                    <jet-section-border />
                    <edit-user-remove :editable="$props.editable" />
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout"
import JetSectionBorder from "@/Jetstream/SectionBorder"
import EditUserInformation from "@/Pages/Admin/Users/Edit/EditUserInformation"
import EditUserRemove from "@/Pages/Admin/Users/Edit/EditUserRemove"
import EditUserPermissions from "@/Pages/Admin/Users/Edit/EditUserPermissions"

export default {
    components: {
        AppLayout,
        JetSectionBorder,
        EditUserInformation,
        EditUserRemove,
        EditUserPermissions
    },
    props: ['editable']
}
</script>
