<?
if($_POST["message"]) {

$email = htmlspecialchars($_POST["email"]);
$name = htmlspecialchars($_POST["name"]);
$phone = htmlspecialchars($_POST["phone"]);
$message = htmlspecialchars($_POST["message"]);


mail("karkinafrost@hootlook.fr", "Commande",
$message."From:".$name ."email :".$email);
}
?>