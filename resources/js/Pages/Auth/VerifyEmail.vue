<template>
    <jet-authentication-card>
        <div class="mb-4 text-sm text-gray-600">
            Vă mulțumim că v-ați înscris! Înainte de a începe, ați putea să vă verificați adresa de e-mail făcând clic pe linkul pe care tocmai vi l-am trimis prin e-mail? Dacă nu ați primit e-mailul, vă vom trimite cu plăcere altul.
        </div>

        <div class="mb-4 font-medium text-sm text-green-600" v-if="verificationLinkSent" >
            Un nou link de verificare a fost trimis pe adresa cu care v-ați înregistrat.
        </div>

        <form @submit.prevent="submit">
            <div class="mt-4 flex items-center justify-between">
                <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Retrimite mailul de verificare
                </jet-button>

                <inertia-link :href="route('logout')" method="post" as="button" class="underline text-sm text-gray-600 hover:text-gray-900">Delogare</inertia-link>
            </div>
        </form>
    </jet-authentication-card>
</template>

<script>
    import JetAuthenticationCard from '@/Jetstream/AuthenticationCard'
    import JetButton from '@/Jetstream/Button'

    export default {
        components: {
            JetAuthenticationCard,
            JetButton,
        },

        props: {
            status: String
        },

        data() {
            return {
                form: this.$inertia.form()
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('verification.send'))
            },
        },

        computed: {
            verificationLinkSent() {
                return this.status === 'verification-link-sent';
            }
        }
    }
</script>
