<?php
require_once('includes/load.php');

// Capturar a URL amigável
$url = isset($_GET['url']) ? $_GET['url'] : 'equipamento';
$urlParts = explode('/', $url);

// Se houver um ID na URL, é porque estamos vendo um equipamento específico
$equipment_id = isset($urlParts[1]) ? (int) $urlParts[1] : 0;

$page_title = 'Todos os Equipamentos';
page_require_level(1);

$equipments = find_all_equipment();
?>

<?php include_once('layouts/header.php'); ?>

<div class="row">
  <div class="col-md-12">
    <?= display_msg($msg); ?>
  </div>
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Todos os Equipamentos</span>
        </strong>
        <div class="pull-right">
          <a href="/equipamento/adicionar" class="btn btn-primary">Adicionar Novo</a>
        </div>
      </div>
      <div class="panel-body">
        <table class="table table-bordered datatable-active">
          <thead>
            <tr>
              <th class="text-center">#</th>                
              <th class="text-center"> Tombo</th>
              <th class="text-center"> Especificações </th>
              <th class="text-center"> Tipo de Equipamento </th>
              <th class="text-center none"> Fabricante </th>
              <th class="text-center none"> Situação </th>
              <th class="text-center none"> Observação </th>
              <th class="text-center none"> Término da Garantia </th>
              <th class="text-center none"> Criado por </th>
              <th class="text-center none"> Criado em </th>
              <th class="text-center none"> Atualizado por </th>
              <th class="text-center none"> Atualizado em </th>
              <th class="text-center"> Ações </th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($equipments as $equipment): ?>
              <tr>
                <td class="text-center"><?= count_id(); ?></td>
                <td class="text-center"><?= remove_junk($equipment['tombo']); ?></td>
                <td><?= remove_junk($equipment['specifications']); ?></td>
                <td class="text-center"><?= remove_junk($equipment['type_equip']); ?></td>                
                <td class="text-center"><?= remove_junk($equipment['manufacturer']); ?></td>                
                <td class="text-center"><?= remove_junk($equipment['situation']); ?></td>                
                <td><?= remove_junk($equipment['obs']); ?></td>
                <td class="text-center">
                  <?php
                    if (!is_null($equipment['warranty'])) {
                      $date = DateTime::createFromFormat('Y-m-d', $equipment['warranty']);
                      echo $date ? $date->format('d/m/Y') : "Data inválida";
                    } else {
                      echo "Sem garantia";
                    }
                  ?>                    
                </td>
                <td><?= remove_junk($equipment['created_user']); ?></td>       
                <td class="text-center">
                  <?php 
                    $date = DateTime::createFromFormat('Y-m-d H:i:s', $equipment['created_at']);
                    echo $date ? $date->format('d/m/Y H:i') : "Data inválida";
                  ?>
                </td>                
                <td><?= remove_junk($equipment['updated_user']); ?></td>
                <td class="text-center">
                  <?php 
                    if (!empty($equipment['updated_at'])) {
                      $date = DateTime::createFromFormat('Y-m-d H:i:s', $equipment['updated_at']);
                      echo $date ? $date->format('d/m/Y H:i') : "Data inválida";
                    }
                  ?>
                </td>
                <td class="text-center">
                  <div class="btn-group">
                    <a href="/equipamento/editar/<?= (int)$equipment['id']; ?>" class="btn btn-xs btn-warning" title="Editar" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-edit"></span>
                    </a>

                    <button title="Remover" type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#launchModal-<?= (int)$equipment['id']; ?>">
                      <i class="glyphicon glyphicon-remove"></i>
                    </button>
                    <?php 
                      $action = "/equipamento/deletar/" . (int)$equipment['id'];
                      $id = (int)$equipment['id'];
                      include('layouts/modal-confirmacao.php'); 
                    ?>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>
