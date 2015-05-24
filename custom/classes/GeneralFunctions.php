<?php

function isMaxReached() {
    $isClosed = true;
    $genericDAO = new GenericDAO;

    if (getUserExemptions($_SESSION['user_id']) || $genericDAO->selectAll("RespostaEdital", "status = 1 AND id_user = ".$_SESSION['user_id'])) return false;

    $genericDAO = new GenericDAO;
    $now = date('Y-m-d H:i:s');
    $fatherProducts = $genericDAO->selectAll("Product", "dt_begin < '$now' AND dt_end > '$now'");
    if ($fatherProducts) {
        if (!is_array($fatherProducts)) $fatherProducts = array($fatherProducts);
        foreach ($fatherProducts as $product) {
            if ($genericDAO->selectAll("ProductFather", "id_father = ".$product->get('id'). " AND id_product <> ".$product->get('id'))) {
                $max = $product->get('max_quantity');
                $count = 0;
                $transactionItems = $genericDAO->selectAll("TransactionItem", "id_product = ".$product->get('id'));
                if ($transactionItems) {
                    if (!is_array($transactionItems)) $transactionItems = array($transactionItems);
                    foreach ($transactionItems as $transactionItem) {
                        $transaction = $genericDAO->selectAll("Transaction", "id = ".$transactionItem->get('id_transaction'));
                        if ($transaction && floatval($transaction->get('value_exemption')) == 0) {
                            if ($transaction->get('status') != 3) {
                                $count++;
                            }
                        }
                    }
                }
                echo "<!-- Product: ".$product->get('id')."; Max/Total: $max / $count -->";
                if ($count <= $max) {
                    $isClosed = false;
                }
            }
        }
    }

    return $isClosed;
}

function userHasProduct($idUser, $idProduct) {
    $genericDAO = new GenericDAO;
    $transactions = $genericDAO->selectAll("Transaction", "id_user = $idUser AND (status = 1 OR status = 0)");
    if ($transactions) {
        if (!is_array($transactions)) $transactions = array($transactions);
        foreach ($transactions as $transaction) {
            $transactionsItems = $genericDAO->selectAll("TransactionItem", "(id_product = $idProduct ".($idProduct == 1 ? 'OR id_product = 7' : ($idProduct == 7 ? 'OR id_product = 1' : '')).") AND id_transaction = ".$transaction->get('id'));
            if ($transactionsItems) return true;
        }
    }

    return false;
}

function sumTotalExemptions($exemptions) {
    $genericDAO = new GenericDAO;
    if ($exemptions) {
        if (!is_array($exemptions)) $exemptions = array($exemptions);
        $totalValue = 0;
        foreach ($exemptions as $exemption) {
            $product = $genericDAO->selectAll("Product", "id = ".$exemption->get('id_product'));
            if ($product) {
                $totalValue += floatval($product->get('price')) * floatval($exemption->get('modifier'));
            }
        }
        if ($totalValue > 0) return $totalValue;
    }
    return false;
}

function getTotalValueExemptions($idUser) {
    $exemptions = getUserExemptions($idUser);
    $total = sumTotalExemptions($exemptions);
    if ($total && $total > 0) return $total;
    return false;
}

function getUserExemptions($idUser) {
    $genericDAO = new GenericDAO;

    $user = $genericDAO->selectAll("Usuario", "id = $idUser");

    $exemptionEmails = $genericDAO->selectAll("ExemptionEmail", "email = '".$user->get('email')."'");
    if ($exemptionEmails) {
        if (!is_array($exemptionEmails)) $exemptionEmails = array($exemptionEmails);
        return $exemptionEmails;
    }

    $selectedEditals = $genericDAO->selectAll("RespostaEdital", "id_user = $idUser AND status = 1");
    if ($selectedEditals) {
        if (!is_array($selectedEditals)) $selectedEditals = array($selectedEditals);

        $highestPackExemption = false;
        $highestValueExemption = 0;
        $selectedEditalsStr = "";
        foreach ($selectedEditals as $selectedEdital) {
            $edital = $genericDAO->selectAll("Edital", "id = ".$selectedEdital->get('id_edital'));
            if ($edital && sizeof($edital) > 0) {
                $exemptions = $genericDAO->selectAll("Exemption", "id_edital = ".$edital->get('id'));
                $totalValue = sumTotalExemptions($exemptions);
                if ($totalValue && $totalValue > $highestValueExemption) {
                    $highestValueExemption = $totalValue;
                    $highestPackExemption = $exemptions;
                }


                // if ($exemptions) {
                //     if (!is_array($exemptions)) $exemptions = array($exemptions);
                //     $totalValue = 0;
                //     foreach ($exemptions as $exemption) {
                //         $product = $genericDAO->selectAll("Product", "id = ".$exemption->get('id_product'));
                //         if ($product) {
                //             $totalValue += floatval($product->get('price')) * floatval($exemption->get('modifier'));
                //         }
                //     }
                //     if ($totalValue > $highestValueExemption) {
                //         $highestValueExemption = $totalValue;
                //         $highestPackExemption = $exemptions;
                //     }
                // }
            }
        }

        if ($highestPackExemption) return $highestPackExemption;
    }

    if ($genericDAO->selectAll("RespostaEdital", "status = 1 AND id_user = $idUser")) return true;

    return false;
}

function userHasExemption($idUser, $idProduct) {
    $genericDAO = new GenericDAO;
    $exemptions = getUserExemptions($idUser);
    if ($exemptions && $exemptions !== true) {
        if (!is_array($exemptions)) $exemptions = array($exemptions);
        foreach ($exemptions as $exemption) {
            if ($exemption->get('id_product') == $idProduct) return $exemption;
        }
    }

    return false;
}

?>