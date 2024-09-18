<?php
$roles = [
  ['id' => 1, 'name' => 'Admin', 'permissions' => [1, 2]],
  ['id' => 2, 'name' => 'User', 'permissions' => [3]]
  
];

echo json_encode($roles);
