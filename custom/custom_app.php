<?php

// Include your customized DAOs, VOs etc. here.

  include_once("classes/Payment.php");
  include_once("classes/GeneralFunctions.php");

  include_once("dao/EditalDAO.php");
  include_once("dao/PerguntaDAO.php");
  include_once("dao/RespostaEditalDAO.php");
  include_once("dao/RespostaEditalStatusDAO.php");
  include_once("dao/ValorPossivelDAO.php");

  include_once("model/Edital.php");
  include_once("model/Exemption.php");
  include_once("model/Pergunta.php");
  include_once("model/Product.php");
  include_once("model/ProductExclude.php");
  include_once("model/RespostaEdital.php");
  include_once("model/RespostaEditalStatus.php");
  include_once("model/RespostaPergunta.php");
  include_once("model/Transaction.php");
  include_once("model/TransactionItem.php");
  include_once("model/TransactionPayment.php");
  include_once("model/UsuarioFull.php");
  include_once("model/ValorPossivel.php");

  include_once("custom/libs/openboleto/autoloader.php");
  include_once("custom/libs/PagSeguroPHPLibrary-2.2.4/PagSeguroLibrary.php");

?>
