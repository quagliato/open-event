<?php

class BlacklistDAO extends GenericDAO {
    function __contruct() {
    }

    public function isBlacklisted($user_email) {
        if (!isset($user_email) || is_null($user_email))
            return true;
        return $this->selectAll("Blacklist", "user_email = '$user_email'");
    }

    public function getBlacklistedById($id) {
        return $this->selectAll("Blacklist", "id = $id");
    }
}
?>
