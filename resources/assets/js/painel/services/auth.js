import Ls from './ls'

export default {

    login(loginData) {

        return axios.post('/api/auth/login', loginData).then(response =>  {
            Ls.set('auth.token',response.data.token)
            toastr['success']('Logado com sucesso!', 'Sucesso');
        }).catch(error => {
            if (error.response.status == 401) {
                toastr['error']('Email ou senha inválida', 'Erro');
            } else {
                // Something happened in setting up the request that triggered an Error
                console.log('Erro', error.message);
            }
        });

    },

    recovery(loginData) {

        return axios.post('/entrar/password/email', loginData).then(response =>  {
            console.log(response)
            // Ls.set('auth.token',response.data.token)
            toastr.success('O link para redefinição de senha foi enviado para o seu e-mail!', 'Sucesso');
        }).catch(error => {
            console.log('Erro', error.message);
        });

    },

    logout(){
        return axios.get('/api/auth/logout').then(response =>  {
            Ls.remove('auth.token');
            Ls.remove('auth.user');
            toastr['success']('Você saiu do Painel!', 'Sucesso');
        }).catch(error => {
            console.log('Erro', error.message);
        });
    },

    check() {
        return axios.get('/api/auth/check').then(response =>  {
          if (response.data.user !== null) {
            let user = JSON.stringify(response.data.user)
            Ls.set('auth.user', user);
          }

          return !!response.data.authenticated;
        }).catch(error => {
            console.log('Erro', error.message);
        });
    },

}