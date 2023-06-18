<template>
    <app-layout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <jet-button v-if="reportType !== 0" class="my-2" @click.native="extractReport">Descarcă raport</jet-button>
                <div class="flex">
                    <danger-button @click.native="generateAutoReport" class="ml-2" v-if="$page.props.user.check['auto report']">Generează raport automobile</danger-button>
                </div>
                <div class="flex justify-center my-3">
                    <vue-excel-editor v-model="autodata" v-if="reportType === 1" :key="reportType" ref="gAuto">
                        <vue-excel-column field="model" label="Modelul automobilului" width="200px" :readonly="true" />
                        <vue-excel-column field="plate" label="Număr de înmatriculare" :readonly="true" width="130px" />
                        <vue-excel-column field="itp_begin" label="Dată eliberare ITP" :readonly="true" width="130px" />
                        <vue-excel-column field="itp_end" label="Dată scadență ITP" :readonly="true" width="130px" />
                        <vue-excel-column field="itp_diff" label="ITP expiră în" :readonly="true" width="150px" />
                        <vue-excel-column field="insurance_begin" label="Dată eliberare Asigurare" :readonly="true" width="130px" />
                        <vue-excel-column field="insurance_end" label="Dată scadență Asigurare" :readonly="true" width="130px" />
                        <vue-excel-column field="insurance_diff" label="Asigurarea expiră în" :readonly="true" width="150px" />
                    </vue-excel-editor>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import DangerButton from "@/Jetstream/DangerButton";
import JetButton from "@/Jetstream/Button";

export default {
    components: {
        AppLayout,
        DangerButton,
        JetButton
    },
    data() {
        return {
            healthdata: [],
            reportType: 0,
            ssmdata: [],
            a1data: [],
            autodata: [],
            depdata: []
        }
    },
    methods: {
        async generateAutoReport() {
            await axios.get(route('admin.raport.auto'))
                .then((res) => {
                    this.autodata = res.data;
                    this.reportType = 1;
                })
                .catch((err) => console.log(err))
        },
        extractReport() {
            switch (this.reportType) {
                case 1: {
                    this.$refs.gAuto.exportTable('xlsx', false, 'Situatie_Auto');
                    break;
                }
            }
        }
    }
}
</script>
