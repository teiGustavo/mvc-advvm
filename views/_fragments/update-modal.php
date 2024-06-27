<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="updateModalLabel">Atualizar Lançamento</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="updateForm" class="needs-validation" action="<?= $formAction; ?>" novalidate>
                <div class="modal-body">
                    <div id="success-alert" class="alert alert-success d-none" role="alert"></div>
                    <div id="danger-alert" class="alert alert-danger d-none" role="alert"></div>
                    
                    <input type="hidden" class="form-control" id="id" name="id" placeholder="Dia do lançamento" required>

                    <div class="form-floating mb-3">
                        <input type="date" class="form-control" id="date" name="date" placeholder="Dia do lançamento" required>
                        <label for="date">Dia</label>
                        <div id="date-feedback" class="invalid-feedback"></div>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="report" name="report" placeholder="Descrição" minlength="3" required>
                        <label for="report">Lançamento</label>
                        <div id="report-feedback" class="invalid-feedback"></div>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="amount" name="amount" placeholder="Valor" required>
                        <label for="amount">Valor</label>
                        <div id="amount-feedback" class="invalid-feedback"></div>
                    </div>

                    <div class="form-floating">
                        <select class="form-select" id="type" name="type" aria-label="Tipo" required>
                            <option value="Entrada">Entrada</option>
                            <option value="Saída">Saída</option>
                        </select>
                        <label for="type">Tipo</label>
                        <div id="type-feedback" class="invalid-feedback"></div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" id="btnCloseUpdateModal" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" id="btnSubmitUpdateModal" class="btn btn-success">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>