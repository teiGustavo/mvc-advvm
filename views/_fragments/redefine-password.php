<div class="modal fade" id="redefinePasswordModal" tabindex="-1" aria-labelledby="redefinePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="redefinePasswordModalLabel">Redefinir Senha</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="redefinePasswordForm" action="<?= $formAction; ?>">
                <div class="modal-body">
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Insira sua senha">
                        <label for="password">Senha</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="repeat-password" name="repeatPassword" placeholder="Insira sua senha novamente" disabled>
                        <label for="repeat-password">Repita sua senha</label>
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