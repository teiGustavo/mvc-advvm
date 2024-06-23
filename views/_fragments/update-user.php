<div class="modal fade" id="updateUserModal" tabindex="-1" aria-labelledby="updateUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="updateUserModalLabel">Modificar Usuário</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="updateUserForm" action="<?= $formAction; ?>">
                <div class="modal-body">
                    <input type="hidden" class="form-control" id="id" name="id">

                    <div class="form-floating">
                        <select class="form-select" id="role" name="role" aria-label="Cargo">
                            <option value="-1">Aguardando Aprovação</option>
                            <option value="0">Usuário</option>
                            <option value="1">Administrador</option>
                        </select>
                        <label for="role">Tipo</label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" id="btnCloseUserUpdateModal" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-success">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>