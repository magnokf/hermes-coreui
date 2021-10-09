<template>
  <CContainer class="d-flex content-center min-vh-100">
    <CRow>
      <CCol>
        <CCardGroup>
          <CCard class="p-4">
            <CCardBody>
              <ValidationObserver>
                <CForm @submit.prevent="login" method="POST">
                  <h1>Entrar</h1>
                  <p class="text-muted">Usar seus Dados CBMERJ</p>
                  <CInput
                      v-on:keyup="validator"
                      valid-feedback="Obrigado :)"
                      invalid-feedback="Forneça pelo menos 4 caracteres."
                      :is-valid="validator"
                      v-model="samaccountname"
                      prependHtml="<i class='cui-user'></i>"
                      placeholder="seu rg cbmerj"
                      autocomplete="username rg"
                  >
                    <template #prepend-content><CIcon name="cil-user"/></template>
                  </CInput>
                  <CInput
                      v-model="password"
                      prependHtml="<i class='cui-lock-locked'></i>"
                      placeholder="Sua senha"
                      type="password"
                      autocomplete="curent-password"
                  >
                    <template #prepend-content><CIcon name="cil-lock-locked"/></template>
                  </CInput>
                  <CRow>
                    <CCol col="12">
                      <CButton type="submit" color="primary" class="col px-4">Entrar</CButton>
                    </CCol>
                  </CRow>
                </CForm>
              </ValidationObserver>

            </CCardBody>
          </CCard>
          <CCard
            color="primary"
            text-color="white"
            class="text-center py-5 d-md-down-none"
            body-wrapper
          >
            <h2>HermesApp</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Commodi cumque deserunt enim fugiat illo in iure maiores nostrum odit, quae quam qui quisquam temporibus vel velit veritatis voluptas. Facilis, repudiandae?</p>
            <a
                class="btn"
                target="_blank"
                href="https://intranet.cbmerj.rj.gov.br/"
            >
              <CImg
                src="https://www.cbmerj.rj.gov.br/images/imagens/logo_bolacha.png"
                class="active mt-3"
            >

              </CImg>
            </a>
          </CCard>
        </CCardGroup>
      </CCol>
    </CRow>
  </CContainer>
</template>

<script>

import axios from "axios";

    export default {
      name: 'Login',
      data() {
        return {
          samaccountname: '',
          password: '',
          showMessage: false,
          message: '',
        }
      },
      methods: {
        validator(val){
          return val ? val.length >= 4 : false
        },
        goRegister(){
          this.$router.push({ path: 'register' });
        },
        login() {
          let self = this;
          axios.post(  this.$apiAdress + '/api/login', {
            samaccountname: self.samaccountname,
            password: self.password,
          }).then(function (response) {
            self.samaccountname = '';
            self.password = '';
            localStorage.setItem("api_token", response.data.access_token);
            localStorage.setItem('roles', response.data.roles);
            self.$router.push({ path: 'dashboard' });
          })
          .catch(function (error) {
            self.message = 'Incorrect E-mail or password';
            self.showMessage = true;
            console.log(error);
          });
  
        }
      }
    }

</script>
