<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="updateModalLabel">Atualizar Lançamento</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="updateForm" action="<?= $formAction; ?>">
                <div class="modal-body">
                    <input type="hidden" class="form-control" id="id" name="id" placeholder="Dia do lançamento">
                    <label for="id" class="d-none"></label>

                    <div class="form-floating mb-3">
                        <input type="date" class="form-control" id="date" name="date" placeholder="Dia do lançamento">
                        <label for="date">Dia</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="amount" name="amount" placeholder="Valor">
                        <label for="amount">Valor</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="report" name="report" placeholder="Descrição">
                        <label for="report">Lançamento</label>
                    </div>

                    <div class="form-floating">
                        <select class="form-select" id="type" name="type" aria-label="Tipo">
                            <option value="Entrada">Entrada</option>
                            <option value="Saída">Saída</option>
                        </select>
                        <label for="type">Tipo</label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" id="btnCloseUpdateModal" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-success">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>