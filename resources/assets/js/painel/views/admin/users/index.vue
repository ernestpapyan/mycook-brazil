<template>
  <div class="main-content">
    <div class="page-header">
      <h3>Usuários</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
        <li class="breadcrumb-item active">Usuários</li>
        <li class="action">
          <router-link :to="'/admin/users/new'" class="btn btn-success btn-xs"><i class="fa fa-plus-circle"></i> Novo</router-link>
        </li>
      </ol>

    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-block">
            <table id="responsive-datatable" class="table table-striped table-bordered" cellspacing="0" width="100%"></table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
    import { HttpService } from '../../../services/httpService';
    export default {
        data: function () {
            return {
                users: []
            }
        },
        mounted() {
            let httpService = new HttpService();
            httpService.build('admin/v1/users')
            .list({query: 'where[role]=admin'})
            .then((res) => {
              this.users = res.data.data;

              let data = [];
              res.data.data.forEach((value) => {
                let action = `<a href="/painel/admin/users/${value.id}/ver" class="btn btn-info btn-xs"><i class="fa fa-eye"></i>Detalhes</a>`;
                data.push([
                  value.id,
                  value.name,
                  value.email,
                  action,
                ]);
              });


            $('#responsive-datatable').DataTable({
                  responsive: true,
                  data: data,
                  language: {
                      url: "assets/js/datatables-pt-br.json"
                    },
                  columns: [
                    {title: "Id", width: "20px"},
                    {title: "Nome"},
                    {title: "Email"},
                    {title: "Ação", width: "70px"},
                  ]
              });
            });

        }
    }
</script>

<style>
    .breadcrumb .action {
        float: left;
        padding-left: 10px;
    }
</style>
