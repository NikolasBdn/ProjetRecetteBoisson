create table User(
    username varchar2(256),
    password varchar2(256),
    primary key (username)
);

create table basket(
    username varchar2(256),
    recipe   int,
    constraint fk_recipe foreign key (recipe) references Recette (recipe),
    constraint fk_username foreign key (username) references User (username)
);
