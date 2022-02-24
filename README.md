# GCE
Projeto open source de sistema web para gestão de centros/casas espíritas.

## Definindo o projeto
### Qual é o projeto?
O projeto GCE é um projeto de desenvolvimento de um sistema web para contribuir na gestão de Centros Espíritas. Será implementado modelo SaaS, assim cada casa espírita poderá fazer seu cadastro e utilizar o sistema sem a necessidade de instalar em estrutura própria.

### O que é o MVP (Produto Viável Mínimo)?
Sistema web será criado utilizando Laravel, Jetstream e Livewire que permita cadastro/gestão de usuários, cadastro/gestão de pacientes, agenda e gestão dos atendimentos.

#### Fluxo de atendimento
O paciente solicita tratamento. É realizado o cadastro do paciente e marcado a data do tratamento.

No dia do tratamento, o usuário/gestor do centro, deve visualizar todos os pacientes marcados naquela data e imprimir a ficha de atendimento de cada paciente.

O mentor realiza o atendimento e anota na ficha os medicamentos, passes a orientações para o paciente.

O paciente volta à recepção e o usuário/gestor insere o atendimento no sistema, inserindo os medicamentos receitados pelo mentor, as observações, e os passes que o paciente deve tomar.

O usuário/gestor marca a data dos passes receitados pelo mentor.

#### MVP
Cadastro de Usuários
Nome, email e perfil de acesso

Cadastro de Pacientes
Nome, nascimento e endereço

Atendimentos
Tipo de atendimento: tratamento (presencial ou a distância), passe (presencial ou a distância)

Tipo de passe (A.E, 3 médiuns, sustentação)


### Quais são as coisas boas de se ter?
Sistema o mais simples possível que possa ser utilizado através de tablet também.

### Quando o projeto será concluído?
O projeto estará concluído assim que todos os recursos do MVP forem implementados
