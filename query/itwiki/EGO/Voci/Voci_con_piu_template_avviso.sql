CONNECT itwiki_p itwiki.labsdb;
SELECT CONCAT("# [[", page_title, "]] (", C, ")")
FROM (SELECT tl_from, COUNT(*) C
      FROM templatelinks
      WHERE tl_namespace = 10
      AND tl_title IN ('S', 'Stub', 'W', 'PW', 'Wikificare','A', 'C',
                       'Da_controllare', 'E', 'T', 'T_sezione', 'P', 'V',
                       'Bufala', 'L', 'Localismo', 'F', 'Senza_fonti',
                       'Senzafonti','U', 'Merge', 'Da_unire', 'Correggere',
                       'Da_correggere', 'Errori_grammaticali', 'NN', 'N',
                       'Controlcopy', 'Voci_senza_uscita', 'Categorizzare',
                       'Tmp', 'Manca_template', 'Tradurre', 'O')
      GROUP BY tl_from
      ORDER BY C DESC
      LIMIT 100) T, page
WHERE page_id = tl_from
AND page_namespace = 0
ORDER BY C DESC;