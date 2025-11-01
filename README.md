Integração com o zapier e google drive: <br/>
<img width="702" height="549" alt="image" src="https://github.com/user-attachments/assets/fe0cce7f-25f0-4c80-95a7-4d6a4069c0ad" />
<img width="422" height="1156" alt="image" src="https://github.com/user-attachments/assets/a68c28e4-84d5-4cca-9121-4db3fd8321ec" />
<img width="410" height="1167" alt="image" src="https://github.com/user-attachments/assets/3556ca0d-978c-43c0-a8b1-0b523af722d1" />

<br/>
### Exemplo de resposta da API `ZapierIntegration`
O endpoint retorna um objeto JSON no seguinte formato:
{
  "ZapierIntegration": [
    {
      "SeqZapierIntegration": 11,
      "NomeIntegracao": "ZapierGoogleDriveAPI",
      "Evento": "unknown",
      "Payload": "\"POST \\\/api\\\/zapier\\\/googleDriveFileUpload HTTP\\\/1.1\\r\\nAccept:            *\\\/*\\r\\nAccept-Encoding:   gzip,deflate\\r\\nAuthorization:     Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0.KMUFsIDTnFmyG3nMiGM6H9FNFUROf3wh7SmqJp-QV30\\r\\nConnection:        upgrade\\r\\nContent-Length:    4180\\r\\nContent-Type:      multipart\\\/form-data; boundary=--------------------------c1874e72152d515ac5629655\\r\\nHost:              www.livrosexpo.site\\r\\nUser-Agent:        Zapier\\r\\nX-Forwarded-For:   44.210.237.189\\r\\nX-Forwarded-Proto: https\\r\\nX-Real-Ip:         44.210.237.189\\r\\n\\r\\n\"",
      "Ativo": true,
      "DataRecebimento": "2025-11-01T01:35:11.000Z",
      "created_at": "2025-11-01T01:35:11.000Z",
      "updated_at": "2025-11-01T01:35:11.000Z",
      "FileLocation": "downloads/Tr9UOYvl49hfj_MC6oaGCLHaLNSUX6K7MoachTyeNtLQKUEUINeJSgfbCro4hLdfxSjYvu_FFQ6a9AJdI0HTJIzgYBF5vq2RqQrh5pHLhSzAUeKQIUTsOAPyjhTF0GAxnYXBwEpT5_MfsJVG14aaGRM92zxlb_qHE5CDiD45K4A",
      "Log": "1-Recebido requisição de : 127.0.0.1 |  | 2-Arquivo salvo com sucesso em: downloads/Tr9UOYvl49hfj_MC6oaGCLHaLNSUX6K7MoachTyeNtLQKUEUINeJSgfbCro4hLdfxSjYvu_FFQ6a9AJdI0HTJIzgYBF5vq2RqQrh5pHLhSzAUeKQIUTsOAPyjhTF0GAxnYXBwEpT5_MfsJVG14aaGRM92zxlb_qHE5CDiD45K4A  http://localhost/storage/downloads/Tr9UOYvl49hfj_MC6oaGCLHaLNSUX6K7MoachTyeNtLQKUEUINeJSgfbCro4hLdfxSjYvu_FFQ6a9AJdI0HTJIzgYBF5vq2RqQrh5pHLhSzAUeKQIUTsOAPyjhTF0GAxnYXBwEpT5_MfsJVG14aaGRM92zxlb_qHE5CDiD45K4A"
    }
  ]
}
