<?php
/**
 * MySQL DB. All data is stored in data_pdo_mysql database
 * Create an empty MySQL database and set the dbname, username
 * and password below
 * 
 * This class will create the table with sample data
 * automatically on first `get` or `get($id)` request
 */
class DB_PDO_MySQL
{
    private $db;
    function __construct ()
    {
        try {
            $this->db = new PDO(
            'mysql:host=localhost;dbname=haran', 'root', '');/*local*/
			//'mysql:host=localhost;dbname=tiexpert_haran', 'tiexpert_haran', '123456');/*tiexpertise*/
			
            $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, 
            PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new RestException(501, 'MySQL: ' . $e->getMessage());
        }
    }

    ///////////////////////////////////
    ///// Event //////////////////
    //////////////////////////////////
    function getEvent ($id, $installTableOnFailure = FALSE)
    {
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        try {
            $sql = 'SELECT * FROM events WHERE id = ' . mysql_escape_string(
            $id);
            return $this->id2int($this->db->query($sql)
                ->fetch());
        } catch (PDOException $e) {
            if (! $installTableOnFailure && $e->getCode() == '42S02') {
                $this->install();
                return $this->getEvent($id, TRUE);
            }
            throw new RestException(501, 'MySQL: ' . $e->getMessage());
        }
    }


    function getAllEvent ($active, $first, $installTableOnFailure = FALSE)
    {
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        try {
            $today = date('Y-m-d');
            $theQuery = 'SELECT * FROM events ';

            if ($active=='true' or $first > 0){
                $theQuery = $theQuery . 'WHERE id > 0 ';
            }

            if ($active=='true'){
                $theQuery = $theQuery . 'AND dateline >= ' . '\'' . mysql_escape_string($today) . '\'' . ' ';
            }
            
            $theQuery = $theQuery . 'ORDER BY dateline ASC ';

            if ($first=='3'){
                $theQuery = $theQuery . 'LIMIT 0,3 ' ;
            }
            $stmt = $this->db->query( $theQuery);
            return $this->id2int($stmt->fetchAll());
        } catch (PDOException $e) {
            if (! $installTableOnFailure && $e->getCode() == '42S02') {
                $this->install();
                return $this->getAllEvent(TRUE);
            }
            throw new RestException(501, 'MySQL: ' . $e->getMessage());
        }
    }
    function insertEvent ($rec)
    {
        $name = mysql_escape_string($rec['name']);
        $url = mysql_escape_string($rec['url']);
        $img = mysql_escape_string($rec['img']);
        $description = mysql_escape_string($rec['description']);
        $street = mysql_escape_string('street');
        $col = mysql_escape_string('col');
        $cp = mysql_escape_string('cp');
        $municipality = mysql_escape_string('municipality');
        $entity = mysql_escape_string('entity');
        $sql = "INSERT INTO events (name, url, img, description, street, col, cp, municipality, entity) VALUES ('$name', '$url', '$img', '$description', '$stret', '$col', '$cp', '$municipality', '$entity')";
        if (! $this->db->query($sql))
            return FALSE;
        return $this->getEvent($this->db->lastInsertId());
    }
    function updateEvent ($id, $rec)
    {
        $id = mysql_escape_string($id);
        $name = mysql_escape_string($rec['name']);
        $url = mysql_escape_string($rec['url']);
        $img = mysql_escape_string($rec['img']);
        $description = mysql_escape_string($rec['description']);
        $street = mysql_escape_string('street');
        $col = mysql_escape_string('col');
        $cp = mysql_escape_string('cp');
        $municipality = mysql_escape_string('municipality');
        $entity = mysql_escape_string('entity');
        $sql = "UPDATE events SET name = '$name', url ='$url', img ='$img', description ='$description', street = '$street', col = '$col', cp ='$cp', municipality = '$municipality', entity = '$entity' WHERE id = $id";
        if (! $this->db->query($sql))
            return FALSE;
        return $this->getEvent($id);
    }
    function deleteEvent ($id)
    {
        $r = $this->getEvent($id);
        if (! $r || ! $this->db->query(
        'DELETE FROM events WHERE id = ' . mysql_escape_string($id)))
            return FALSE;
        return $r;
    }


    private function id2int ($r)
    {
        if (is_array($r)) {
            if (isset($r['id'])) {
                $r['id'] = intval($r['id']);
            } else {
                foreach ($r as &$r0) {
                    $r0['id'] = intval($r0['id']);
                }
            }
        }
        return $r;
    }
    private function install ()
    {
        $this->db->exec(
        "CREATE TABLE events (
            id INT AUTO_INCREMENT PRIMARY KEY ,
            name TEXT NOT NULL ,
            url TEXT ,
            img TEXT NOT NULL,
            description TEXT NOT NULL,
            dateline DATE NOT NULL,
            street TEXT NOT NULL,
            col TEXT NOT NULL, 
            cp TEXT NOT NULL,
            municipality TEXT NOT NULL, 
            entity TEXT NOT NULL
        );");
        $this->db->exec(
        "INSERT INTO events (name, url, img, description, dateline, street, col, cp, municipality, entity) VALUES ('Torneo', 'http://www.tiexpertise.com.mx', 'http://placehold.it/318x412', 'Animate gran torneo', '2014-12-31', 'Calle sin numero','colonia','12345','Jesús María','Aguascalientes');
         INSERT INTO events (name, url, img, description, dateline, street, col, cp, municipality, entity) VALUES ('Examen', 'http://www.tiexpertise.com.mx', 'http://placehold.it/318x412', 'Todas las edades...','2014-03-03','Otra Calle','otra colonia','23445','Calvillo','Aguascalientes');
         INSERT INTO events (name, url, img, description, dateline, street, col, cp, municipality, entity) VALUES ('Combate', 'http://www.tiexpertise.com.mx', 'http://placehold.it/318x412', 'Mas descripción', '2014-01-25', 'calle','colonia','23323','Aguascalientes','Aguascalientes');
         INSERT INTO events (name, url, img, description, dateline, street, col, cp, municipality, entity) VALUES ('Otro Evento', 'http://www.tiexpertise.com.mx', 'http://placehold.it/318x412', 'test test test', '1979-10-31', 'asdfas','asds','22222','Miguel Hidalgo','Distrito Federal');
        ");


    }
}
