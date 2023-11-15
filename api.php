<?php
    function MonitoringInfo($id,$cpf,$idioma){
        $date = date('d/m/Y H:i:s');
        $http = [
            'Host: servicos-cloud.saude.gov.br',
            'Sec-Ch-Ua: "Chromium";v="119", "Not?A_Brand";v="24"',
            'Accept: application/json, text/plain, */*',
            'Sec-Ch-Ua-Mobile: ?0',
            'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyX25hbWUiOiIyMzU5ODkxMzI0OSIsIm9yaWdlbSI6IlNDUEEiLCJpc3MiOiJzYXVkZS5nb3YuYnIiLCJub21lIjoicGF1bG8gaGVucmlxdWUgZGUgamVzdXMgc2FudGFuYSIsImF1dGhvcml0aWVzIjpbIlJPTEVfU0ktUE5JX09FU0MiLCJST0xFX1NJLVBOSV9HTSIsIlJPTEVfU0ktUE5JIiwiUk9MRV9TQ1BBX0dFUyIsIlJPTEVfU0NQQV9VU1IiLCJST0xFX1NJLVBOSV9HRVNBIiwiUk9MRV9TQ1BBIl0sImNsaWVudF9pZCI6IlNJLVBOSSIsInNjb3BlIjpbIkNOU0RJR0lUQUwiLCJHT1ZCUiIsIlNDUEEiXSwiY25lcyI6Im51bGwiLCJvcmdhbml6YXRpb24iOiJEQVRBU1VTIiwiY3BmIjoiMjM1OTg5MTMyNDkiLCJleHAiOjE3MDAwNTA0MTcsImp0aSI6IjE3MmE0MWUwLTM3YjMtNDkwZC04MmRjLThhOWRhNmVhMTU1MyIsImtleSI6Ijk5MDk3IiwiZW1haWwiOiJwYXVsb3phcmEwMUB5YWhvby5jb20uYnIifQ.MAupWZYz511LN4ltOyJwrj4ut8ji1QQfWgsYdfdSjOo',
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.6045.123 Safari/537.36',
            'Sec-Ch-Ua-Platform: "Windows"',
            'Origin: https://si-pni.saude.gov.br',
            'Sec-Fetch-Site: same-site',
            'Sec-Fetch-Mode: cors',
            'Sec-Fetch-Dest: empty',
            'Referer: https://si-pni.saude.gov.br/',
            'Priority: u=1, i',
        ];
        $curl = curl_init();
        curl_setopt_array($curl,[
            CURLOPT_URL => "https://servicos-cloud.saude.gov.br/pni-bff/v1/cidadao/cpf/$cpf",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => $http,
        ]);
        $result = curl_exec($curl);
        $result =  json_decode($result, true);
        curl_close($curl);
        $personalinformation = array();
        $paisinformation = array();
        $municipioinformation = array();
        $vaccineinformation = array();
        if($result["code"]=='200'){
            $personalinformation["cnsDefinitivo"] = $result["records"][0]["cnsDefinitivo"];
            $personalinformation["cnsProvisorio"] = $result["records"][0]["cnsProvisorio"][0];
            $personalinformation["nome"] = $result["records"][0]["nome"];
            $personalinformation["cpf"] = $result["records"][0]["cpf"];
            $personalinformation["dataNascimento"] = $result["records"][0]["dataNascimento"];
            $personalinformation["sexo"] = $result["records"][0]["sexo"];
            $personalinformation["nomeMae"] = $result["records"][0]["nomeMae"];
            $personalinformation["nomePai"] = $result["records"][0]["nomePai"];
            $personalinformation["obito"] = $result["records"][0]["obito"];
            $personalinformation["ddi"] = $result["records"][0]["telefone"][0]["ddi"];
            $personalinformation["ddd"] = $result["records"][0]["telefone"][0]["ddd"];
            $personalinformation["numero"] = $result["records"][0]["telefone"][0]["numero"];
            $personalinformation["nacionalidade"] = $result["records"][0]["nacionalidade"]["nacionalidade"];
            $personalinformation["municipioNascimento"] = $result["records"][0]["nacionalidade"]["municipioNascimento"];
            $personalinformation["paisNascimento"] = $result["records"][0]["nacionalidade"]["paisNascimento"];
            $personalinformation["logradouro"] = $result["records"][0]["endereco"]["logradouro"];
            $personalinformation["numero"] = $result["records"][0]["endereco"]["numero"];
            $personalinformation["complemento"] = $result["records"][0]["endereco"]["complemento"];
            $personalinformation["bairro"] = $result["records"][0]["endereco"]["bairro"];
            $personalinformation["municipio"] = $result["records"][0]["endereco"]["municipio"];
            $personalinformation["siglaUf"] = $result["records"][0]["endereco"]["siglaUf"];
            $personalinformation["cep"] = $result["records"][0]["endereco"]["cep"];
            if($personalinformation["sexo"]=="M"){
                $personalinformation["sexo"] = "MASCULINE";
            }else{
                $personalinformation["sexo"] = "FEMININE";
            }
            $personalinformation["obito"] = "DATA NOT FOUND";
             // ! SECUND RESQUEST FOR SERVER [ PAIS INFO ]
            $http = [
                'Host: servicos-cloud.saude.gov.br',
                'Sec-Ch-Ua: "Chromium";v="119", "Not?A_Brand";v="24"',
                'Accept: application/json, text/plain, */*',
                'Sec-Ch-Ua-Mobile: ?0',
                'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyX25hbWUiOiIyMzU5ODkxMzI0OSIsIm9yaWdlbSI6IlNDUEEiLCJpc3MiOiJzYXVkZS5nb3YuYnIiLCJub21lIjoicGF1bG8gaGVucmlxdWUgZGUgamVzdXMgc2FudGFuYSIsImF1dGhvcml0aWVzIjpbIlJPTEVfU0ktUE5JX09FU0MiLCJST0xFX1NJLVBOSV9HTSIsIlJPTEVfU0ktUE5JIiwiUk9MRV9TQ1BBX0dFUyIsIlJPTEVfU0NQQV9VU1IiLCJST0xFX1NJLVBOSV9HRVNBIiwiUk9MRV9TQ1BBIl0sImNsaWVudF9pZCI6IlNJLVBOSSIsInNjb3BlIjpbIkNOU0RJR0lUQUwiLCJHT1ZCUiIsIlNDUEEiXSwiY25lcyI6Im51bGwiLCJvcmdhbml6YXRpb24iOiJEQVRBU1VTIiwiY3BmIjoiMjM1OTg5MTMyNDkiLCJleHAiOjE3MDAwNTA0MTcsImp0aSI6IjE3MmE0MWUwLTM3YjMtNDkwZC04MmRjLThhOWRhNmVhMTU1MyIsImtleSI6Ijk5MDk3IiwiZW1haWwiOiJwYXVsb3phcmEwMUB5YWhvby5jb20uYnIifQ.MAupWZYz511LN4ltOyJwrj4ut8ji1QQfWgsYdfdSjOo',
                'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.6045.123 Safari/537.36',
                'Sec-Ch-Ua-Platform: "Windows"',
                'Origin: https://si-pni.saude.gov.br',
                'Sec-Fetch-Site: same-site',
                'Sec-Fetch-Mode: cors',
                'Sec-Fetch-Dest: empty',
                'Referer: https://si-pni.saude.gov.br/',
                'Priority: u=1, i',
                
            ];
            $curl = curl_init();
            curl_setopt_array($curl,[
                CURLOPT_URL => "https://servicos-cloud.saude.gov.br/pni-bff/v1/pais/".$personalinformation["nacionalidade"],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_TIMEOUT => 60,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => $http,
            ]);
            $pais = curl_exec($curl);
            $pais =  json_decode($pais, true);
            curl_close($curl);
            if($pais["code"]=='200'){
                $paisinformation["nome"] = $pais["record"]["nome"];
                $paisinformation["sigla"] = $pais["record"]["sigla"];
            }
            $http = [
                'Host: servicos-cloud.saude.gov.br',
                'Sec-Ch-Ua: "Chromium";v="119", "Not?A_Brand";v="24"',
                'Accept: application/json, text/plain, */*',
                'Sec-Ch-Ua-Mobile: ?0',
                'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyX25hbWUiOiIyMzU5ODkxMzI0OSIsIm9yaWdlbSI6IlNDUEEiLCJpc3MiOiJzYXVkZS5nb3YuYnIiLCJub21lIjoicGF1bG8gaGVucmlxdWUgZGUgamVzdXMgc2FudGFuYSIsImF1dGhvcml0aWVzIjpbIlJPTEVfU0ktUE5JX09FU0MiLCJST0xFX1NJLVBOSV9HTSIsIlJPTEVfU0ktUE5JIiwiUk9MRV9TQ1BBX0dFUyIsIlJPTEVfU0NQQV9VU1IiLCJST0xFX1NJLVBOSV9HRVNBIiwiUk9MRV9TQ1BBIl0sImNsaWVudF9pZCI6IlNJLVBOSSIsInNjb3BlIjpbIkNOU0RJR0lUQUwiLCJHT1ZCUiIsIlNDUEEiXSwiY25lcyI6Im51bGwiLCJvcmdhbml6YXRpb24iOiJEQVRBU1VTIiwiY3BmIjoiMjM1OTg5MTMyNDkiLCJleHAiOjE3MDAwNTA0MTcsImp0aSI6IjE3MmE0MWUwLTM3YjMtNDkwZC04MmRjLThhOWRhNmVhMTU1MyIsImtleSI6Ijk5MDk3IiwiZW1haWwiOiJwYXVsb3phcmEwMUB5YWhvby5jb20uYnIifQ.MAupWZYz511LN4ltOyJwrj4ut8ji1QQfWgsYdfdSjOo',
                'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.6045.123 Safari/537.36',
                'Sec-Ch-Ua-Platform: "Windows"',
                'Origin: https://si-pni.saude.gov.br',
                'Sec-Fetch-Site: same-site',
                'Sec-Fetch-Mode: cors',
                'Sec-Fetch-Dest: empty',
                'Referer: https://si-pni.saude.gov.br/',
                'Priority: u=1, i',
                
            ];
            $curl = curl_init();
            curl_setopt_array($curl,[
                CURLOPT_URL => "https://servicos-cloud.saude.gov.br/pni-bff/v1/municipio/".$personalinformation["municipioNascimento"],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_TIMEOUT => 60,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => $http,
            ]);
            $result = curl_exec($curl);
            $result =  json_decode($result, true);
            curl_close($curl);
            if($result["code"]=='200'){
                $municipioinformation["codigo"] = $result["record"]["codigo"];
                $municipioinformation["nome"] = $result["record"]["nome"];
                $municipioinformation["siglaUf"] = $result["record"]["siglaUf"];
                $municipioinformation["codigoUf"] = $result["record"]["codigoUf"];
                 
            // ! SECUND RESQUEST FOR SERVER [ CALENDARIO CPF INFO ]
            $http = [
                'Host: servicos-cloud.saude.gov.br',
                'Sec-Ch-Ua: "Chromium";v="119", "Not?A_Brand";v="24"',
                'Accept: application/json, text/plain, */*',
                'Sec-Ch-Ua-Mobile: ?0',
                'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyX25hbWUiOiIyMzU5ODkxMzI0OSIsIm9yaWdlbSI6IlNDUEEiLCJpc3MiOiJzYXVkZS5nb3YuYnIiLCJub21lIjoicGF1bG8gaGVucmlxdWUgZGUgamVzdXMgc2FudGFuYSIsImF1dGhvcml0aWVzIjpbIlJPTEVfU0ktUE5JX09FU0MiLCJST0xFX1NJLVBOSV9HTSIsIlJPTEVfU0ktUE5JIiwiUk9MRV9TQ1BBX0dFUyIsIlJPTEVfU0NQQV9VU1IiLCJST0xFX1NJLVBOSV9HRVNBIiwiUk9MRV9TQ1BBIl0sImNsaWVudF9pZCI6IlNJLVBOSSIsInNjb3BlIjpbIkNOU0RJR0lUQUwiLCJHT1ZCUiIsIlNDUEEiXSwiY25lcyI6Im51bGwiLCJvcmdhbml6YXRpb24iOiJEQVRBU1VTIiwiY3BmIjoiMjM1OTg5MTMyNDkiLCJleHAiOjE3MDAwNTA0MTcsImp0aSI6IjE3MmE0MWUwLTM3YjMtNDkwZC04MmRjLThhOWRhNmVhMTU1MyIsImtleSI6Ijk5MDk3IiwiZW1haWwiOiJwYXVsb3phcmEwMUB5YWhvby5jb20uYnIifQ.MAupWZYz511LN4ltOyJwrj4ut8ji1QQfWgsYdfdSjOo',
                'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.6045.123 Safari/537.36',
                'Sec-Ch-Ua-Platform: "Windows"',
                'Origin: https://si-pni.saude.gov.br',
                'Sec-Fetch-Site: same-site',
                'Sec-Fetch-Mode: cors',
                'Sec-Fetch-Dest: empty',
                'Referer: https://si-pni.saude.gov.br/',
                'Priority: u=1, i',
                
            ];
            $curl = curl_init();
            curl_setopt_array($curl,[
                CURLOPT_URL => "https://servicos-cloud.saude.gov.br/pni-bff/v1/calendario/cpf/".$personalinformation["cpf"],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_TIMEOUT => 60,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => $http,
            ]);
            $result = curl_exec($curl);
            $result =  json_decode($result, true);
            curl_close($curl);
            if($result["code"]=='200'){
                $vaccineinformation["sigla"] = $result["record"]["imunizacoesCampanha"]["imunobiologicos"][0]["sigla"];
                $vaccineinformation["abreviatura"] = $result["record"]["imunizacoesCampanha"]["imunobiologicos"][0]["abreviatura"];
                $vaccineinformation["nome"] = $result["record"]["imunizacoesCampanha"]["imunobiologicos"][0]["nome"];
                $vaccineinformation["id"] = $result["record"]["imunizacoesCampanha"]["imunobiologicos"][0]["imunizacoes"][0]["id"];
                $vaccineinformation["sistemaOrigem"] = $result["record"]["imunizacoesCampanha"]["imunobiologicos"][0]["imunizacoes"][0]["sistemaOrigem"];
                $vaccineinformation["nomeCampanha"] = $result["record"]["imunizacoesCampanha"]["imunobiologicos"][0]["imunizacoes"][0]["nomeCampanha"];
                $vaccineinformation["dataAplicacao"] = $result["record"]["imunizacoesCampanha"]["imunobiologicos"][0]["imunizacoes"][0]["dataAplicacao"];
                $vaccineinformation["lote"] = $result["record"]["imunizacoesCampanha"]["imunobiologicos"][0]["imunizacoes"][0]["lote"];
                $vaccineinformation["nomeEstabelecimentoSaude"] = $result["record"]["imunizacoesCampanha"]["imunobiologicos"][0]["imunizacoes"][0]["nomeEstabelecimentoSaude"];
                $vaccineinformation["idadeAplicacao"] = $result["record"]["imunizacoesCampanha"]["imunobiologicos"][0]["imunizacoes"][0]["idadeAplicacao"];
                $vaccineinformation["nomeProfissionalSaude"] = $result["record"]["imunizacoesCampanha"]["imunobiologicos"][0]["imunizacoes"][0]["nomeProfissionalSaude"];
                $vaccineinformation["razaoSocial"] = $result["record"]["imunizacoesCampanha"]["imunobiologicos"][0]["imunizacoes"][0]["razaoSocial"];
                $vaccineinformation["transmitidaRNDS"] = $result["record"]["imunizacoesCampanha"]["imunobiologicos"][0]["imunizacoes"][0]["transmitidaRNDS"];
                $vaccineinformation["fabricante"] = $result["record"]["imunizacoesCampanha"]["imunobiologicos"][0]["imunizacoes"][0]["fabricante"];
                $vaccineinformation["descricaoGrupoAtendimento"] = $result["record"]["imunizacoesCampanha"]["imunobiologicos"][0]["imunizacoes"][0]["descricaoGrupoAtendimento"];
                // ! SAVE FOR FILES
                if($idioma=="BR"){
                    $save = "NOME COMPLETO: ".$personalinformation["nome"]." | DATA DE NASCIMENTO: ".$personalinformation["dataNascimento"]." | ÓBITO: ".$personalinformation["obito"]."\nCNS DEFINITIVO: ".$personalinformation["cnsDefinitivo"]." | CNS PROVISÓRIO: ".$personalinformation["cnsProvisorio"]."\nCPF: ".$personalinformation["cpf"]." | SEXUALIDADE: ".$personalinformation["sexo"]."\nNOME DA MÃE: ".$personalinformation["nomeMae"]."\nNOME DO PAI: ".$personalinformation["nomePai"]."\nNACIONALIDADE: ".$paisinformation["nome"]." | ABREVIAÇÃO: ".$paisinformation["sigla"]."\nMUNICÍPIO: ".$municipioinformation["nome"]."\nLOGRADOURO: ".$personalinformation["logradouro"]."\nDISTRITO: ".$personalinformation["bairro"]."\nCOMPLEMENTO: ".$personalinformation["complemento"]."\nNÚMERO DE CASA: ".$personalinformation["numero"]."\nCEP: ".$personalinformation["cep"]."\n### DETALHES DA VACINA COVID-19 ###\n"."ACRÔNIMO: ".$vaccineinformation["sigla"]."\nABREVIAÇÃO: ".$vaccineinformation["abreviatura"]."\nNOME: ".$vaccineinformation["nome"]."\nPROTOCOLO: ".$vaccineinformation["id"]."\nSISTEMA DE ORIGEM: ".$vaccineinformation["sistemaOrigem"]."\nNOME DA CAMPANHA: ".$vaccineinformation["nomeCampanha"]."\nDATA DE APLICAÇÃO: ".$vaccineinformation["dataAplicacao"]."\nLOTE: ".$vaccineinformation["lote"]."\nNOME ESTABELECIMENTO DE SAÚDE: ".$vaccineinformation["nomeEstabelecimentoSaude"]."\nIDADE APLICADA: ".$vaccineinformation["idadeAplicacao"]."\nNOME DO PROFISSIONAL DE SAÚDE: ".$vaccineinformation["nomeProfissionalSaude"]."\nRAZÃO SOCIAL: ".$vaccineinformation["razaoSocial"]."\nFABRICANTE: ".$vaccineinformation["fabricante"]."\nDESCRIÇÃO DO GRUPO DE SERVIÇO: ".$vaccineinformation["descricaoGrupoAtendimento"]."\n";
                    $dir = "./db/br/".date('d_m_Y');
                    $file = "./db/br/".date('d_m_Y')."/".$id.".txt";
                    if(!is_dir($dir)){
                        mkdir($dir);
                    }
                    $file_save = fopen($file, "w+");
                    fwrite($file_save, $save);
                    fclose($file_save);
                    echo"\e[0;32;42m[ • ] \e[0m\e[0;42m SI-PNI SUCCESS : ID: $id | CPF/CNS: $cpf  | [ BOT TELEGRAM | $date ] "."\e[0m\e[0;32;42m[ • ] \e[0m\n";
                    return $save;
                }else{
                    $save = "FULL NAME: ".$personalinformation["nome"]." | DATE OF BIRTH: ".$personalinformation["dataNascimento"]." | OBIT: ".$personalinformation["obito"]."\nCNS DEFINITIVE: ".$personalinformation["cnsDefinitivo"]." | CNS PROVISIONAL: ".$personalinformation["cnsProvisorio"]."\nCPF: ".$personalinformation["cpf"]." | SEXUALITY: ".$personalinformation["sexo"]."\nMOTHER'S NAME: ".$personalinformation["nomeMae"]."\nFATHER'S NAME: ".$personalinformation["nomePai"]."\nNATIONALITY: ".$paisinformation["nome"]." | ABBREVIATION: ".$paisinformation["sigla"]."\nCOUNTY: ".$municipioinformation["nome"]."\nPUBLIC PLACE: ".$personalinformation["logradouro"]."\nDISTRICT: ".$personalinformation["bairro"]."\nCOMPLEMENT: ".$personalinformation["complemento"]."\nNUMBER OF HOME: ".$personalinformation["numero"]."\nZIP CODE: ".$personalinformation["cep"]."\n### COVID-19 VACCINE DETAILS ###\n"."ACRONYM: ".$vaccineinformation["sigla"]."\nABBREVIATION: ".$vaccineinformation["abreviatura"]."\nNAME: ".$vaccineinformation["nome"]."\nPROTOCOL: ".$vaccineinformation["id"]."\nORIGIN SYSTEM: ".$vaccineinformation["sistemaOrigem"]."\nCAMPAIGN NAME: ".$vaccineinformation["nomeCampanha"]."\nAPPLICATION DATE: ".$vaccineinformation["dataAplicacao"]."\nBATCH: ".$vaccineinformation["lote"]."\nNAME HEALTH CARE ESTABLISHMENT: ".$vaccineinformation["nomeEstabelecimentoSaude"]."\nAPPLIED AGE: ".$vaccineinformation["idadeAplicacao"]."\nHEALTH PROFESSIONAL NAME: ".$vaccineinformation["nomeProfissionalSaude"]."\nCORPORATE NAME: ".$vaccineinformation["razaoSocial"]."\nMANUFACTURER: ".$vaccineinformation["fabricante"]."\nSERVICE GROUP DESCRIPTION: ".$vaccineinformation["descricaoGrupoAtendimento"]."\n";
                    $dir = "./db/all/".date('d_m_Y');
                    $file = "./db/all/".date('d_m_Y')."/".$id.".txt";
                    if(!is_dir($dir)){
                        mkdir($dir);
                    }
                    $file_save = fopen($file, "w+");
                    fwrite($file_save, $save);
                    fclose($file_save);
                    echo"\e[0;32;42m[ • ] \e[0m\e[0;42m SI-PNI SUCCESS : ID: $id | CPF/CNS: $cpf  | [ BOT TELEGRAM ] | $date ] "."\e[0m\e[0;32;42m[ • ] \e[0m\n";
                    return $save;
                    }
                }
            }
        }else{
            echo"\e[1;31;41m[ • ] \e[0m\e[0;41m SI-PNI INVALID : ID: $id | CPF/CNS: $cpf  | [ BOT TELEGRAM ] | $date ] "."\e[0m\e[1;31;41m[ • ] \e[0m\n";

        }
    }
?>