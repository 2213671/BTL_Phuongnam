<?php
class ContactModel extends DB {

    public function saveContact($data) {
        $sql = "INSERT INTO contacts (name, email, subject, message, phone, created_at) VALUES (:name, :email, :subject, :message, :phone, NOW())";
        return $this->query($sql, $data);
    }

    public function getAllContacts() {
        return $this->all("SELECT * FROM contacts ORDER BY created_at DESC");
    }

    public function getContactById($id) {
        return $this->single("SELECT * FROM contacts WHERE id = :id", ['id' => $id]);
    }

    public function deleteContact($id) {
        return $this->query("DELETE FROM contacts WHERE id = :id", ['id' => $id]);
    }

    public function updateContactStatus($id, $status) {
        $sql = "UPDATE contacts SET status = :status WHERE id = :id";
        return $this->query($sql, ['status' => $status, 'id' => $id]);
    }
}
