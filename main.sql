    use u521495583_derco;

    select
    e.*,
    p.fecha,
    p.turno
    from
    estacionamiento as eestacionamiento
    inner join programacion as p ON p.estacionamiento_id = e.id
    where e.sede_id  = 1 AND p.fecha = '2024-02-12'