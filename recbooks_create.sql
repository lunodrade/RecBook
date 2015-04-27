-- Created by Vertabelo (http://vertabelo.com)
-- Last modification date: 2015-04-27 03:52:02.781



-- foreign keys
ALTER TABLE tb_likes DROP FOREIGN KEY tb_likes_tb_livros;
ALTER TABLE tb_likes DROP FOREIGN KEY tb_likes_tb_usuarios;
ALTER TABLE tb_livros DROP FOREIGN KEY tb_livros_tb_generos;
ALTER TABLE tb_tagslivros DROP FOREIGN KEY tb_tagslivros_tb_livros;
ALTER TABLE tb_tagslivros DROP FOREIGN KEY tb_tagslivros_tb_tags;

-- tables
-- Table tb_generos
DROP TABLE tb_generos;
-- Table tb_likes
DROP TABLE tb_likes;
-- Table tb_livros
DROP TABLE tb_livros;
-- Table tb_tags
DROP TABLE tb_tags;
-- Table tb_tagslivros
DROP TABLE tb_tagslivros;
-- Table tb_usuarios
DROP TABLE tb_usuarios;



-- End of file.

-- Created by Vertabelo (http://vertabelo.com)
-- Last modification date: 2015-04-27 03:52:02.781




-- tables
-- Table tb_generos
CREATE TABLE tb_generos (
    pk_gen_cod int    NOT NULL  AUTO_INCREMENT,
    gen_nome varchar(20)    NOT NULL ,
    gen_desc varchar(50)    NOT NULL ,
    CONSTRAINT tb_generos_pk PRIMARY KEY (pk_gen_cod)
) COMMENT 'Os gêneros que categorizam os livros'
;

-- Table tb_likes
CREATE TABLE tb_likes (
    pk_likes_cod int    NOT NULL  AUTO_INCREMENT,
    like_pontos int    NOT NULL ,
    fk_usu_cod int    NOT NULL ,
    fk_livro_cod int    NOT NULL ,
    CONSTRAINT tb_likes_pk PRIMARY KEY (pk_likes_cod)
) COMMENT 'Tabela que guarda os livros que cada usuário avaliou para si'
;

-- Table tb_livros
CREATE TABLE tb_livros (
    pk_livro_cod int    NOT NULL  AUTO_INCREMENT,
    livro_nome varchar(100)    NOT NULL ,
    livro_desc varchar(200)    NOT NULL ,
    fk_gen_cod int    NOT NULL ,
    CONSTRAINT tb_livros_pk PRIMARY KEY (pk_livro_cod)
) COMMENT 'Tabela que guarda os livros e seus detalhes'
;

-- Table tb_tags
CREATE TABLE tb_tags (
    pk_tag_cod int    NOT NULL  AUTO_INCREMENT,
    tag_nome varchar(20)    NOT NULL ,
    CONSTRAINT tb_tags_pk PRIMARY KEY (pk_tag_cod)
) COMMENT 'As tags presentes em todos livros'
;

-- Table tb_tagslivros
CREATE TABLE tb_tagslivros (
    pk_tagslivros_cod int    NOT NULL  AUTO_INCREMENT,
    fk_tag_cod int    NOT NULL ,
    fk_livro_cod int    NOT NULL ,
    CONSTRAINT tb_tagslivros_pk PRIMARY KEY (pk_tagslivros_cod)
) COMMENT 'Tabela que permite a ligação de N..N entre tb_tags e tb_livros, afinal um livro pode ter nenhuma ou várias tags, assim como uma tag pode estar em nenhum ou vários livros.'
;

-- Table tb_usuarios
CREATE TABLE tb_usuarios (
    pk_usu_cod int    NOT NULL  AUTO_INCREMENT,
    usu_email varchar(100)    NOT NULL ,
    usu_senha varchar(50)    NOT NULL ,
    usu_tipo varchar(20)    NOT NULL ,
    usu_conf bool    NOT NULL ,
    usu_hash varchar(100)    NOT NULL ,
    usu_nome varchar(50)    NOT NULL ,
    usu_sexo varchar(2)    NOT NULL ,
    usu_idade int    NOT NULL ,
    CONSTRAINT tb_usuarios_pk PRIMARY KEY (pk_usu_cod)
) COMMENT 'Tabela que gerencia os dados do usuário'
;





-- foreign keys
-- Reference:  tb_likes_tb_livros (table: tb_likes)


ALTER TABLE tb_likes ADD CONSTRAINT tb_likes_tb_livros FOREIGN KEY tb_likes_tb_livros (fk_livro_cod)
    REFERENCES tb_livros (pk_livro_cod);
-- Reference:  tb_likes_tb_usuarios (table: tb_likes)


ALTER TABLE tb_likes ADD CONSTRAINT tb_likes_tb_usuarios FOREIGN KEY tb_likes_tb_usuarios (fk_usu_cod)
    REFERENCES tb_usuarios (pk_usu_cod);
-- Reference:  tb_livros_tb_generos (table: tb_livros)


ALTER TABLE tb_livros ADD CONSTRAINT tb_livros_tb_generos FOREIGN KEY tb_livros_tb_generos (fk_gen_cod)
    REFERENCES tb_generos (pk_gen_cod);
-- Reference:  tb_tagslivros_tb_livros (table: tb_tagslivros)


ALTER TABLE tb_tagslivros ADD CONSTRAINT tb_tagslivros_tb_livros FOREIGN KEY tb_tagslivros_tb_livros (fk_livro_cod)
    REFERENCES tb_livros (pk_livro_cod);
-- Reference:  tb_tagslivros_tb_tags (table: tb_tagslivros)


ALTER TABLE tb_tagslivros ADD CONSTRAINT tb_tagslivros_tb_tags FOREIGN KEY tb_tagslivros_tb_tags (fk_tag_cod)
    REFERENCES tb_tags (pk_tag_cod);




INSERT INTO tb_usuarios
(usu_email, usu_senha, usu_tipo, usu_conf, usu_hash, usu_nome, usu_sexo, usu_idade) 
VALUES
('uchiha.luciano@gmail.com', '123456', 'user', 1, '', 'Luciano' ,'m', 24),
('fersoares.fs@gmail.com', '123456', 'admin', 1, '', 'Fernanda','f' ,23 );

INSERT INTO tb_tags
(tag_nome) 
VALUES
('chick lit'),
('sobrenatural'),
('policial'),
('mitologia'),
('suspense'),
('aventura'),
('humor'),
('politica'),
('young adult'),
('classico'),
('drama'); 

INSERT INTO tb_generos
(gen_nome, gen_desc) 
VALUES
('ficcao', 'historias criadas para o enternimento' ),
('poesia', 'poemas e poesias' ),
('romance', 'novelas criadas para todos os publicos'),
('terror', 'historias de crimes, suspense ou sobrenatural'),
('historico','romances baseados em fatos historicos' ),
('fantasia', 'historias fantasticas');

INSERT INTO tb_livros
(livro_nome, livro_desc, fk_gen_cod) 
VALUES
('1984', 'Distopia em que um recebe a tarefa de perpetuar a propaganda do regime através da falsificação de documentos públicos e da literatura a fim de que o governo sempre esteja correto no que faz.', 1),
('A Menina que Roubava Livros', 'A trajetória de Liesel Meminger é contada por uma narradora mórbida, porém surpreendentemente simpática, a Morte.', 3),
('A Culpa é das Estrelas', 'História de amor entre dois adolescentes com câncer.' , 3),
('O Pequeno Principe', 'Por meio de uma narrativa poética, o livro busca apresentar uma visão diferente de mundo, levando o leitor a mergulhar no próprio inconsciente, reencontrando sua criança.', 1),
('O Morro dos Ventos Uivantes', 'Na fazenda chamada Morro dos Ventos Uivantes nasce uma paixão devastadora entre Heathcliff e Catherine, amigos de infância e cruelmente separados pelo destino', 3),
('Melancia', 'Claire é abandonada pelo marido quando está dando a luz à sua filha. Agora ela precisa recomeçar sua vida pensando na filha recém nascida', 3),
('Os Homens que não Amavam as Mulheres', 'Um mistério onde os dois protagonistas tentam desvendar envolvendo a elite sueca.', 1),
('A Guerra dos Tronos', 'Primeiro livro de uma saga cheia de intrigas e traições onde um reino está em guerra depois que o Rei morre.', 6),
('Orgulho e Preconceito', 'Romance histórico que conta a história de amor entre Elizabeth Bennet e Mr. Darcy', 3),
('Cosmópolis', 'Conta um dia na vida de um investidor bilionário que está sendo ameaçado de morte.', 1),
('Dom Casmurro', 'Conta a história de amor de Bentinho e Capitu e como o ciume transformar uma pessoa.', 3),
('Ao Farol', 'As relações de amizade de uma familia influente de Londres no século 20 e os desdobrar dessa relação quando o membro principal morre.', 3),
('Travessuras de Menina Má', 'Conta a história de um homem que é apaixonado pela mesma mulher desde a adolescencia mas ela vive sumindo da sua vida.', 3),
('Guerra e Paz', 'Clássico sobre as guerras napoleonicas na Russia' , 5),
('O Hobbit', 'História fantastica onde Bilbo Bolseiro, a pedido de Gandalf, ajuda os anões a retomarem a Montanha Solitária', 6),
('O Teorema Katherine', 'História do homem que ao todo namorou 19 Katherines', 3),
('1808', 'Como uma rainha louca, um príncipe medroso e uma corte corrupta enganaram Napoleão e mudaram a História de Portugal e do Brasil', 5),
('As Aventuras de Sherlock Holmes', 'Sherlock Holmes é um famoso detetive, em tanto excêntrico, que tenta solucionar mistérios acompanhado por seu fiel escudeiro Watson.', 1),
('Antologia Poetica', 'Antologia com o melhor da poesia de Fernando Pessoa, pelos olhos de sua maior especialista.', 2),
('Vinte Poemas de Amor e uma Canção Desesperada', 'Livro de poesias de Pablo Neruda', 2),
('O Iluminado', 'Livro mais de terror mais famoso de Stephen King', 4),
('Psicose', 'Livro que deu origem ao famoso filme de Alfred Hitchcock', 4),
('O Médico e o Monstro', 'A história assustadora do infernal alter ego do Dr. Jekyll e da busca através das ruas escuras de Londres que culmina numa terrível revelação. ', 4),
('Toda Poesia', 'Coletânea de poesias de Paulo Leminski', 2),
('Os Três Mosqueteiros', 'Conta a história de DArtagnan que vai a Paris para fazer parte da nobre guarda do rei. ', 5),
('Os Delírios de Consumo de Becky Bloom', 'A vida de uma garota viciada em compras muda quando ela se vê falida', 3),
('A Mulher de Preto', 'Vida de jovem advogado muda quando começa a investigar a morte de uma mulher', 4);

INSERT INTO tb_tagslivros
(fk_tag_cod, fk_livro_cod) 
VALUES
(8, 1),
(10, 1),
(11, 2),
(11, 3),
(9, 3),
(10, 4),
(10, 5),
(11, 5),
(1, 6),
(7, 6),
(11, 7),
(3, 7),
(11, 8),
(5, 8),
(4, 8),
(6, 8),
(10, 9),
(11, 10),
(5, 10),
(10, 11),
(10, 12),
(11, 12),
(5, 13),
(11, 13),
(11, 14),
(10, 14),
(8, 14),
(6, 15),
(7, 15),
(4, 15),
(11, 16),
(9, 16),
(8, 17),
(7, 17),
(6, 18),
(8, 18),
(7, 18),
(10, 18),
(10, 19),
(11, 20),
(10, 20),
(10, 21),
(5, 21),
(11, 21),
(2, 21),
(5, 22),
(5, 23),
(10, 24),
(10, 25),
(6, 25),
(1, 26),
(7, 26),
(5, 27),
(2, 27);


-- End of file.
