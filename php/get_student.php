<?php

include '../connection/config.php';

if(isset($_GET['page'])){
    $page=$_GET['page'];
}else{
    $page=1;
}

$limit=2;

$offset=($limit -1)*$page;

$sql="SELECT * FROM students ORDER BY id DESC LIMIT $offset,$limit";
$sql_run=mysqli_query($conn,$sql);
$output="";
if(mysqli_num_rows($sql_run) > 0){
    $output .=" <table class='min-w-full bg-white'>
    <thead class='bg-gray-100'>
        <tr>
            <th class='text-left py-2 px-4 font-bold text-gray-700'>Name</th>
            <th class='text-left py-2 px-4 font-bold text-gray-700'>Email</th>
            <th class='text-left py-2 px-4 font-bold text-gray-700'>Phone</th>
            <th class='text-left py-2 px-4 font-bold text-gray-700'>Date of Birth</th>
            <th class='text-left py-2 px-4 font-bold text-gray-700'>Edit</th>
            <th class='text-left py-2 px-4 font-bold text-gray-700'>Delete</th>
        </tr>
    </thead>
    <tbody>";
    while($row=mysqli_fetch_assoc($sql_run)){
        $output .="<tr>
        <td class='border-t py-2 px-4'>{$row['name']}</td>
        <td class='border-t py-2 px-4'>{$row['email']}</td>
        <td class='border-t py-2 px-4'>{$row['phone']}</td>
        <td class='border-t py-2 px-4'>{$row['date_of_birth']}</td>
        <td class='border-t py-2 px-4'><a href='update.php?id={$row['id']}' class='bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-4 rounded'>Edit</a></td>
        <td class='border-t py-2 px-4'><a data-id='{$row['id']}' id='delete-student'  class='bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-4 rounded'>Delete</a></td>
    </tr>";
    }
    $output.="</tbody>
    </table>";

    $sql2="SELECT * FROM students";
    $sql_run2=mysqli_query($conn,$sql2);
    $total=mysqli_num_rows($sql_run2);
    $pages=ceil($total/$limit);
    $output .="<nav class='isolate inline-flex -space-x-px rounded-md shadow-sm pagination' aria-label='Pagination'>";
    for($i=1;$i<=$pages;$i++){
        if($i == $page){
            $active='bg-indigo-600 text-white';
        }else{
            $active="";
        }
        $output .="<a href='#' data-id='{$i}' aria-current='page' class=' {$active} relative z-10 inline-flex items-center  px-4 py-2 text-sm font-semibold text-black focus:z-20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600'>{$i}</a>";
    }
    $output .="</nav>";
}

   

echo $output;
