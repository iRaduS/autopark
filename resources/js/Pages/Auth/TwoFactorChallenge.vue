<template>
    <jet-authentication-card>
        <div class="mb-4 text-sm text-gray-600">
            <template v-if="! recovery">
                Vă rugăm să confirmați accesul la contul dvs. introducând codul de autentificare furnizat de aplicația dvs. de autentificare.
            </template>

            <template v-else>
                Vă rugăm să confirmați accesul la contul dvs. introducând unul dintre codurile de recuperare de urgență.
            </template>
        </div>

        <jet-validation-errors class="mb-4" />

        <form @submit.prevent="submit">
            <div v-if="! recovery">
                <jet-label for="code" value="Codul" />
                <jet-input ref="code" id="code" type="text" inputmode="numeric" class="mt-1 block w-full" v-model="form.code" autofocus autocomplete="one-time-code" />
            </div>

            <div v-else>
                <jet-label for="recovery_code" value="Codul de recuperare" />
                <jet-input ref="recovery_code" id="recovery_code" type="text" class="mt-1 block w-full" v-model="form.recovery_code" autocomplete="one-time-code" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <button type="button" class="text-sm text-gray-600 hover:text-gray-900 underline cursor-pointer" @click.prevent="toggleRecovery">
                    <template v-if="! recovery">
                        Folosește un cod de recuperare
                    </template>

                    <template v-else>
                        Folosește un cod de autentificare
                    </template>
                </button>

                <jet-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Autentifică-mă
                </jet-button>
            </div>
        </form>
    </jet-authentication-card>
</template>

<script>
    import JetAuthenticationCard from '@/Jetstream/AuthenticationCard'
    import JetButton from '@/Jetstream/Button'
    import JetInput from '@/Jetstream/Input'
    import JetLabel from '@/Jetstream/Label'
    import JetValidationErrors from '@/Jetstream/ValidationErrors'

    export default {
        components: {
            JetAuthenticationCard,
            JetButton,
            JetInput,
            JetLabel,
            JetValidationErrors,
        },

        data() {
            return {
                recovery: false,
                form: this.$inertia.form({
                    code: '',
                    recovery_code: '',
                })
            }
        },

        methods: {
            toggleRecovery() {
                this.recovery ^= true

                this.$nextTick(() => {
                    if (this.recovery) {
                        this.$refs.recovery_code.focus()
                        this.form.code = '';
                    } else {
                        this.$refs.code.focus()
                        this.form.recovery_code = ''
                    }
                })
            },

            submit() {
                this.form.post(this.route('two-factor.login'))
            }
        }
    }
</script>
