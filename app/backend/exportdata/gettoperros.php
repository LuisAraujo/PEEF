<?php

//top erros
//SELECT typeError, enhancedmessage.subtype as subtype, count(*) as quant FROM `compilation`INNER JOIN enhancedmessage ON enhancedmessage.id = enhancedmessagefound WHERE typeError <> "no-error" GROUP BY typeError, subtype ORDER BY quant DESC

//erros nao cobertos //execuções com erro sem mensagens melhoradas (quais os erros)
//SELECT typeError, erromessage, compMessage, count(*) as quant FROM `compilation`LEFT JOIN enhancedmessage ON enhancedmessage.id = enhancedmessagefound WHERE typeError <> "no-error" AND enhancedmessagefound = 0 GROUP BY typeError, subtype ORDER BY quant DESC

//SELECT Enrollment.Student_id, Compilation.id, typeError, erromessage, compMessage FROM `compilation` INNER JOIN Code ON Code.id = Code_id INNER JOIN Project ON Code.Project_id = Project.id INNER JOIN Enrollment ON Enrollment.id =  Project.Enrollment_id  LEFT JOIN enhancedmessage ON enhancedmessage.id = enhancedmessagefound  WHERE Enrollment.Course_id = 2 AND  typeError <> "no-error"

//execucoes com erro
//SELECT count(*) as quant FROM `compilation` WHERE typeError <> "no-error"


//dash sumary
//quantidade de execuções
//quantidade de execução com erro
//quantidade de teste
//quantidade de falhas


//get activities by students
//quantidade de execuções
//quantidade de execução com erro
//quantidade de execuções sem erro
//quantidade de teste
//quantidade de falhas
//quantidade de pass


//quantidade de execuçoes e testes por semana (atvs)
//SELECT count(*) as complitaion, (CASE WHEN Activity_id <= 17 THEN '1' WHEN Activity_id <= 28  THEN '2' WHEN Activity_id <= 37 THEN '3' ELSE '4' END) AS week FROM Compilation INNER JOIN Code ON Compilation.Code_id = Code.id INNER JOIN Project ON Code.Project_id = Project.id INNER JOIN enrollment ON enrollment.id = project.Enrollment_id WHERE enrollment.Course_id = '2' AND compilation.testpassed = '-1' GROUP By week

//erro
//SELECT count(*) as complitaion, (CASE WHEN Activity_id <= 17 THEN '1' WHEN Activity_id <= 28  THEN '2' WHEN Activity_id <= 37 THEN '3' ELSE '4' END) AS week FROM Compilation INNER JOIN Code ON Compilation.Code_id = Code.id INNER JOIN Project ON Code.Project_id = Project.id INNER JOIN enrollment ON enrollment.id = project.Enrollment_id WHERE enrollment.Course_id = '2' AND compilation.testpassed = '-1' AND typeError <> "no-error" GROUP By week

//teste
//SELECT count(*) as complitaion, (CASE WHEN Activity_id <= 17 THEN '1' WHEN Activity_id <= 28  THEN '2' WHEN Activity_id <= 37 THEN '3' ELSE '4' END) AS week FROM Compilation INNER JOIN Code ON Compilation.Code_id = Code.id INNER JOIN Project ON Code.Project_id = Project.id INNER JOIN enrollment ON enrollment.id = project.Enrollment_id WHERE enrollment.Course_id = '2' AND compilation.testpassed <> '-1' GROUP By week

//faill
//SELECT count(*) as complitaion, (CASE WHEN Activity_id <= 17 THEN '1' WHEN Activity_id <= 28  THEN '2' WHEN Activity_id <= 37 THEN '3' ELSE '4' END) AS week FROM Compilation INNER JOIN Code ON Compilation.Code_id = Code.id INNER JOIN Project ON Code.Project_id = Project.id INNER JOIN enrollment ON enrollment.id = project.Enrollment_id WHERE enrollment.Course_id = '2' AND compilation.testpassed = '0' GROUP By week



//quantidade de execuções (erro x sucess) teste (fall x pass) por aluno
//no error
//SELECT count(*) as compilation, Enrollment.Student_id FROM Compilation INNER JOIN Code ON Compilation.Code_id = Code.id INNER JOIN Project ON Code.Project_id = Project.id  INNER JOIN enrollment ON Project.Enrollment_id =  enrollment.id WHERE Project.id in (SELECT Project.id as id FROM Project INNER JOIN Enrollment ON Enrollment.id = Project.Enrollment_id INNER JOIN Activity ON Activity.id = Project.Activity_id  WHERE Compilation.typeError = "no-error" AND Enrollment.Student_id in ( SELECT Student_id FROM enrollment WHERE Course_id = 2) ) GROUP By Enrollment.Student_id

//error
//SELECT count(*) as compilation, Enrollment.Student_id FROM Compilation INNER JOIN Code ON Compilation.Code_id = Code.id INNER JOIN Project ON Code.Project_id = Project.id  INNER JOIN enrollment ON Project.Enrollment_id =  enrollment.id WHERE Project.id in (SELECT Project.id as id FROM Project INNER JOIN Enrollment ON Enrollment.id = Project.Enrollment_id INNER JOIN Activity ON Activity.id = Project.Activity_id  WHERE Compilation.typeError <> "no-error" AND Enrollment.Student_id in ( SELECT Student_id FROM enrollment WHERE Course_id = 2) ) GROUP By Enrollment.Student_id

//teste faill
//SELECT count(*) as compilation, Enrollment.Student_id FROM Compilation INNER JOIN Code ON Compilation.Code_id = Code.id INNER JOIN Project ON Code.Project_id = Project.id  INNER JOIN enrollment ON Project.Enrollment_id =  enrollment.id WHERE Project.id in (SELECT Project.id as id FROM Project INNER JOIN Enrollment ON Enrollment.id = Project.Enrollment_id INNER JOIN Activity ON Activity.id = Project.Activity_id  WHERE Compilation.testpassed = "0" AND Enrollment.Student_id in ( SELECT Student_id FROM enrollment WHERE Course_id = 2) ) GROUP By Enrollment.Student_id

//teste sucess
//SELECT count(*) as compilation, Enrollment.Student_id FROM Compilation INNER JOIN Code ON Compilation.Code_id = Code.id INNER JOIN Project ON Code.Project_id = Project.id  INNER JOIN enrollment ON Project.Enrollment_id =  enrollment.id WHERE Project.id in (SELECT Project.id as id FROM Project INNER JOIN Enrollment ON Enrollment.id = Project.Enrollment_id INNER JOIN Activity ON Activity.id = Project.Activity_id  WHERE Compilation.testpassed = "1" AND Enrollment.Student_id in ( SELECT Student_id FROM enrollment WHERE Course_id = 2) ) GROUP By Enrollment.Student_id


//no sumary list - dados por semana x cada atividade

//quantidade de execuções
//quantidade de execução com erro
//quantidade de execuções sem erro
//quantidade de teste
//quantidade de falhas
//quantidade de pass


//DIF médio por estudantes e atividades

//em metrics
//Tempo para solução das atividades por estudante e atividades

//em metrics
//EQ por aluno e atividade

//em metrics
//RED por aluno e atividade

//Quantidade total de testes e execuções (por estudante)
//execucoes
//SELECT count(*) as compilation, Enrollment.Student_id FROM Compilation INNER JOIN Code ON Compilation.Code_id = Code.id INNER JOIN Project ON Code.Project_id = Project.id  INNER JOIN enrollment ON Project.Enrollment_id =  enrollment.id WHERE Project.id in (SELECT Project.id as id FROM Project INNER JOIN Enrollment ON Enrollment.id = Project.Enrollment_id INNER JOIN Activity ON Activity.id = Project.Activity_id  WHERE Compilation.testpassed = "-1" AND Enrollment.Student_id in ( SELECT Student_id FROM enrollment WHERE Course_id = 2) ) GROUP By Enrollment.Student_id
//test
//SELECT count(*) as compilation, Enrollment.Student_id FROM Compilation INNER JOIN Code ON Compilation.Code_id = Code.id INNER JOIN Project ON Code.Project_id = Project.id INNER JOIN enrollment ON Project.Enrollment_id = enrollment.id WHERE Project.id in (SELECT Project.id as id FROM Project INNER JOIN Enrollment ON Enrollment.id = Project.Enrollment_id INNER JOIN Activity ON Activity.id = Project.Activity_id WHERE Compilation.testpassed <> "-1" AND Enrollment.Student_id in ( SELECT Student_id FROM enrollment WHERE Course_id = 2) ) GROUP By Enrollment.Student_id

