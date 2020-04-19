<?php

use CubitD\C4\Components\System;
use CubitD\C4\Shapes\ActorShapeType;
use CubitD\C4\SvgRenderSystem;
use CubitD\Core\Diagram;
use CubitD\Core\Layouts\SimpleLayoutGenerator;
use CubitD\Core\Project;
use SimpleBank\Shapes\CloudShapeType;
use SimpleBank\Shapes\Svg\SvgCloudShape;

require __DIR__ . '/../../../vendor/autoload.php';

$renderSystem = new SvgRenderSystem();
$renderSystem->addShapeType(new SvgCloudShape());

$project = new Project('Simple Bank');

$diagram1 = new Diagram('C1 diagram');
$project->addDiagram($diagram1);

$d1UserActor = new System('Client',
    $renderSystem->getShapeFactory()->create(ActorShapeType::getShapeType()),
    'Bank client who uses our services');
$diagram1->addElement($d1UserActor);

$d1BankMainframe = new System('Bank mainframe',
    $renderSystem->getShapeFactory()->create(ActorShapeType::getShapeType()),
    'Main banking mainframe which collects data from all banks');
$diagram1->addElement($d1BankMainframe);

$d1Mailing = new System('Mailing system',
    $renderSystem->getShapeFactory()->create(CloudShapeType::getShapeType()),
    'External system for sending e-mail to the clients');
$diagram1->addElement($d1Mailing);

$d1International = new System('International bank cloud',
    $renderSystem->getShapeFactory()->create(CloudShapeType::getShapeType()),
    'International banking system used for exchanging data with other banking institutes');
$diagram1->addElement($d1International);

$d1MainApplication = new System('Main application',
    $renderSystem->getShapeFactory()->create(ActorShapeType::getShapeType()),
    'Our main application for single bank which delivers services for clients');
$diagram1->addElement($d1MainApplication);


$d1UserActor->uses($d1MainApplication);
$d1MainApplication->uses($d1BankMainframe);
$d1MainApplication->uses($d1Mailing);
$d1BankMainframe->uses($d1International);
$d1MainApplication->uses($d1International);

$d1BankMainframe->toLeftOf($d1MainApplication);
$d1UserActor->toTopOf($d1MainApplication);
$d1Mailing->toRightOf($d1MainApplication);
$d1International->toBottomOf($d1BankMainframe);


echo 'Project diagram 1 render: <br>';
$layoutGenerator = new SimpleLayoutGenerator();
echo $renderSystem->getDiagramRenderer()->render($diagram1, $layoutGenerator);
