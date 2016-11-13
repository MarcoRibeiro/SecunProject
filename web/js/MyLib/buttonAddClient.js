function activeButtonLink(clientID) {
   $('.novoClienteLink').off('click').on('click', function(){
    swal.withForm({
        title: "Novo Cliente",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
        confirmButtonText: "Registar",
        cancelButtonText: "Cancelar",
        formFields: [
            { id: 'nome', placeholder: 'Nome' },
            { id: 'contacto', placeholder: 'Contacto', type: 'number' },
            { id: 'morada', placeholder: 'Morada' },
            { id: 'email', placeholder: 'Email', type: 'email' }
        ]
    },
    function(isConfirm){
        if (isConfirm){
            $.ajax({
                type: 'POST',
                url: 'operations/client/saveClient.php',
                data: this.swalForm,
                dataType: 'json'
            }).done(function(response) {
                swal("Cliente registado!", "", "success");
                if($("#tableOfClients").data('jsGrid')){
                    $("#tableOfClients").jsGrid("render");
                }
            }).fail(function(response){
                swal.showInputError('Impossivel registar','','error');
            });
        }
    });
});

    $('.novoEquipamentoLink').off('click').on('click', function(){
        swal.withForm({
            title: "Novo Equipamento",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            confirmButtonText: "Registar",
            cancelButtonText: "Cancelar",
            formFields: [
                { id: 'modelo', placeholder: 'Modelo' },
                { id: 'imei', placeholder: 'IMEI / Nº Serie'},
                { id: 'obj', placeholder: 'Observações' }
            ]
        },
        function(isConfirm){
            if (isConfirm){
                $.ajax({
                    type: 'POST',
                    url: 'operations/equipment/saveEqui.php',
                    data: $.extend(true, this.swalForm, {id:clientID}),
                    dataType: 'json'
                }).done(function(response) {
                    swal("Equipamento registado!", "", "success");
                }).fail(function(response){
                    swal.showInputError('Impossivel registar','','error');
                });
            }
        });
    })
}

