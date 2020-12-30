create table User (
    username varchar(64),
    password varchar(256),
    primary key (username)
);

create table basket(
    username varchar(64),
    recipe   int,
    constraint fk_recipe foreign key (recipe) references Recette (id),
    constraint fk_username foreign key (username) references User (username)
);
