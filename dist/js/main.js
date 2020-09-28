/**	 * Passa os dados do cliente para o Modal, e atualiza o link para exclusão	 */
$('#delete-modal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id = button.data('customer');
    var modal = $(this);
    //modal.find('.modal-title').text('O sistema precisa de sua confirmação'); 
    modal.find('#confirm').attr('href', 'delete.php?id=' + id);
})

/**	 * Passa os dados do cliente para o Modal, e atualiza o link para redefenir senha	 */
$('#resetar-senha').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id = button.data('customer');
    var modal = $(this);
    //modal.find('.modal-title').text('O sistema precisa de sua confirmação'); 
    modal.find('#confirm').attr('href', 'redefine_senha.php?id=' + id);
})

/**	 * Passa os dados do cliente para o Modal, e atualiza o link para redefenir senha	 */
$('#fechar-modal').on('show.bs.modal', function (event) {

    var button = $(event.relatedTarget);
    var id = button.data('customer');
    var modal = $(this);
    //modal.find('.modal-title').text('O sistema precisa de sua confirmação');
    modal.find('#confirm').attr('href', 'fechar.php?fechar_id=' + id);
})

/**	 * Passa os dados do cliente para o Modal, e atualiza o link para redefenir senha	 */
$('#delete-resp-modal').on('show.bs.modal', function (event) {

    var button = $(event.relatedTarget);
    var id = button.data('customer');
    var modal = $(this);
    //modal.find('.modal-title').text('O sistema precisa de sua confirmação');
    modal.find('#confirm').attr('href', 'delete.php?resp_id=' + id);
})

/**	 * Passa os dados do chamado para o Modal, e atualiza o chamado */
$('#abrir-modal').on('show.bs.modal', function (event) {

    var button = $(event.relatedTarget);
    var id = button.data('customer');
    var modal = $(this);
    //modal.find('.modal-title').text('O sistema precisa de sua confirmação');
    modal.find('#confirm').attr('href', 'fechar.php?abrir_id=' + id);
})

