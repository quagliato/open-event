<?php

// Include your customized DAOs, VOs etc. here.
  $custom_classes = array(

    "Payment" => "classes/Payment.php",
    "GeneralFunctions" => "classes/GeneralFunctions.php",

    "EditalDAO" => "dao/EditalDAO.php",
    "PerguntaDAO" => "dao/PerguntaDAO.php",
    "RespostaEditalDAO" => "dao/RespostaEditalDAO.php",
    "RespostaEditalStatusDAO" => "dao/RespostaEditalStatusDAO.php",
    "ValorPossivelDAO" => "dao/ValorPossivelDAO.php",

    "Edital" => "model/Edital.php",
    "EmailMessage" => "model/EmailMessage.php",
    "Exemption" => "model/Exemption.php",
    "ExemptionEmail" => "model/ExemptionEmail.php",
    "Pergunta" => "model/Pergunta.php",
    "Product" => "model/Product.php",
    "ProductExclude" => "model/ProductExclude.php",
    "ProductFather" => "model/ProductFather.php",
    "RespostaEdital" => "model/RespostaEdital.php",
    "RespostaEditalStatus" => "model/RespostaEditalStatus.php",
    "RespostaPergunta" => "model/RespostaPergunta.php",
    "Transaction" => "model/Transaction.php",
    "TransactionItem" => "model/TransactionItem.php",
    "TransactionPayment" => "model/TransactionPayment.php",
    "TransactionTransfer" => "model/TransactionTransfer.php",
    "User" => "model/UserFull.php",
    "ValorPossivel" => "model/ValorPossivel.php",

    "autoloader" => "libs/openboleto/autoloader.php",
    "PagSeguroLibrary" => "libs/PagSeguroPHPLibrary-2.2.4/PagSeguroLibrary.php",
  );

?>
