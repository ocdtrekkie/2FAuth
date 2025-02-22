<template>
    <div>
        <!-- webauthn registration -->
        <form-wrapper v-if="showWebauthnRegistration" :title="$t('auth.authentication')" :punchline="$t('auth.webauthn.enhance_security_using_webauthn')">
            <div v-if="deviceRegistered" class="field">
                <label class="label mb-5">{{ $t('auth.webauthn.device_successfully_registered') }}&nbsp;<font-awesome-icon :icon="['fas', 'check']" /></label>
                <form @submit.prevent="handleDeviceSubmit" @keydown="deviceForm.onKeydown($event)">
                    <form-field :form="deviceForm" fieldName="name" inputType="text" placeholder="iPhone 12, TouchID, Yubikey 5C" :label="$t('auth.forms.name_this_device')" />
                    <form-buttons :isBusy="deviceForm.isBusy" :isDisabled="deviceForm.isDisabled" :caption="$t('commons.continue')" />
                </form>
            </div>
            <div v-else class="field is-grouped">
                <!-- register button -->
                <div class="control">
                    <button type="button" @click="registerWebauthnDevice()" class="button is-link">{{ $t('auth.webauthn.register_a_new_device') }}</button>
                </div>
                <!-- dismiss button -->
                <div class="control">
                    <router-link :to="{ name: 'accounts', params: { toRefresh: true } }" class="button is-text">{{ $t('auth.maybe_later') }}</router-link>
                </div>
            </div>
        </form-wrapper>
        <!-- User registration form -->
        <form-wrapper v-else :title="$t('auth.register')" :punchline="$t('auth.forms.register_punchline')">
            <form @submit.prevent="handleRegisterSubmit" @keydown="registerForm.onKeydown($event)">
                <form-field :form="registerForm" fieldName="name" inputType="text" :label="$t('auth.forms.name')" autofocus />
                <form-field :form="registerForm" fieldName="email" inputType="email" :label="$t('auth.forms.email')" />
                <form-field :form="registerForm" fieldName="password" inputType="password" :label="$t('auth.forms.password')" />
                <form-field :form="registerForm" fieldName="password_confirmation" inputType="password" :label="$t('auth.forms.confirm_password')" />
                <form-buttons :isBusy="registerForm.isBusy" :isDisabled="registerForm.isDisabled" :caption="$t('auth.register')" />
            </form>
            <div class="nav-links">
                <p>{{ $t('auth.forms.already_register') }}&nbsp;<router-link :to="{ name: 'login' }" class="is-link">{{ $t('auth.sign_in') }}</router-link></p>
            </div>
        </form-wrapper>
    </div>
</template>

<script>

    import Form from './../../components/Form'

    export default {
        data(){
            return {
                registerForm: new Form({
                    name : '',
                    email : '',
                    password : '',
                    password_confirmation : '',
                }),
                deviceForm: new Form({
                    name : '',
                }),
                showWebauthnRegistration: false,
                deviceRegistered: false,
                deviceId : null,
            }
        },

        methods : {
            /**
             * Register a new user
             */
            async handleRegisterSubmit(e) {
                e.preventDefault()

                this.registerForm.post('/user', {returnError: true})
                .then(response => {
                    this.showWebauthnRegistration = true
                })
                .catch(error => {
                    if( error.response.status === 422 && error.response.data.errors.name ) {

                        this.$notify({ type: 'is-danger', text: this.$t('errors.already_one_user_registered') + ' ' + this.$t('errors.cannot_register_more_user'), duration:-1 })
                    }
                    else if( error.response.status !== 422 ) {

                        this.$router.push({ name: 'genericError', params: { err: error.response } });
                    }
                });
            },


            /**
             * Register a new security device
             */
            async registerWebauthnDevice() {
                // Check https context
                if (!window.isSecureContext) {
                    this.$notify({ type: 'is-danger', text: this.$t('errors.https_required') })
                    return false
                }

                // Check browser support
                if (!window.PublicKeyCredential) {
                    this.$notify({ type: 'is-danger', text: this.$t('errors.browser_does_not_support_webauthn') })
                    return false
                }

                const registerOptions = await this.axios.post('/webauthn/register/options').then(res => res.data)
                const publicKey = this.parseIncomingServerOptions(registerOptions)
                let bufferedCredentials

                try {
                    bufferedCredentials = await navigator.credentials.create({ publicKey })
                }
                catch (error) {
                    if (error.name == 'AbortError') {
                        this.$notify({ type: 'is-warning', text: this.$t('errors.aborted_by_user') })
                    }
                    else if (error.name == 'NotAllowedError' || 'InvalidStateError') {
                        this.$notify({ type: 'is-danger', text: this.$t('errors.security_device_unsupported') })
                    }
                    return false
                }

                const publicKeyCredential = this.parseOutgoingCredentials(bufferedCredentials);

                this.axios.post('/webauthn/register', publicKeyCredential).then(response => {
                    this.deviceId = publicKeyCredential.id
                    this.deviceRegistered = true
                })
            },


            /**
             * Rename the registered device
             */
            async handleDeviceSubmit(e) {

                await this.deviceForm.patch('/webauthn/credentials/' + this.deviceId + '/name')

                if( this.deviceForm.errors.any() === false ) {
                    this.$router.push({name: 'accounts', params: { toRefresh: true }})
                }
            },

        },

        beforeRouteLeave (to, from, next) {
            this.$notify({
                clean: true
            })

            next()
        }
    }
</script>