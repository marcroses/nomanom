class TipusLocal {
    constructor(id, nom, tipus) {
        this.id = parseInt(id);
        this.nom = nom;
        this.tipus_nom = tipus;
        this.color = "#"+id.toString(16)
    };
}