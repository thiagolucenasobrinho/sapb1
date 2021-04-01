<?php
/*
Classe para acesso API Rest SAP B1
*/
class SAP{
	/*
	Funcao de Login
	*/
	public function login($force=false){        
        require_once('config.php');
        $cookie='cookie.txt';
        $data_arq=date("U",filemtime($cookie));
        $diff=time()-$data_arq;
        //Faco a verificacao se o tempo de expiracao da sessao esta proximo, ou se esta sendo forcado o login
        if($diff>1000 || $force=='force'){

            $dados=array(
                'CompanyDB'=>SAP_BD,
                'UserName'=>SAP_USUARIO,
                'Password'=>SAP_SENHA
            );
            $post=json_encode($dados);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, SAP_URL);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie); //Gravo o Cookie, nao envio nenhum cookie para o SAP
            $json = curl_exec($ch);
            curl_close($ch);

            return $json;
        }
    }
}