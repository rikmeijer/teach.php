<?php
namespace Teach\Interactions;

interface Database {
    public function getBeginsituatie($identifier): array;
    
    public function getLeerdoelen($les_id): array;
    
    public function getMedia($les_id): array;
    
    public function getActiviteit($id): array;
    
    public function getKern($les_id): array;
}