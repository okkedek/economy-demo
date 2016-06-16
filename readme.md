# Intro

In contrast to the more frontend oriented <a href="https://github.com/okkedek/voxelprinter">voxelprinter demo</a>, this application aims to demonstrate backend techniques, 
including Domain Driven Design (DDD), Command Query Responsibility Segregation (CQRS), Event Sourcings (ES), 
microservices, API's, etc.


## Domain

Since we'll be working with DDD, lets start out by describing our fictitious domain in terms of a _ubiquitous language_:

> This application models a marketplace where __consumers__ __trade__ 
__products__ with __shops__ for __tokens__. Every shop __sells__ only a 
single type of product with limited __stock__. Every product costs one 
__token__. 
Shops can only sell product after they have __opened__. If a shop runs out 
of stock it __closes__. 
Consumer can only buy product after they have __entered__ the marketplace
and until the have __left__.
 
## Commands, Events and Exceptions

Here this list of commands and events that may occur in this model:

<table>
<tr>
<td>command</td>
<td>events</td>
<td>exceptions</td>
</tr>
<tr>
<td>OpenShop</td>
<td>ShopOpened</td>
<td>-</td>
</tr>
<tr>
<td>CloseShop</td>
<td>ShopClosed</td>
<td>ShopAlreadyClosed</td>
</tr>
<tr>
<td>EnterMarket</td>
<td>ConsumerEntered</td>
<td>ConsumerAlreadyEntered</td>
</tr>
<tr>
<td>LeaveMarket</td>
<td>ConsumerLeft</td>
<td>ConsumerNotInMarketplace</td>
</tr>
<tr>
<td>TradeProductForToken</td>
<td>ProductSold, ShopClosed</td>
<td>ShopNotFound, ConsumerNotFound, ShopIsClosed, ShopOutOfStock, ConsumerHasInsufficientTokens</td>
</tr>
</table>


## Aggregates, ValueObjects and Entities

We can identify the following object types:

<table>
<tr>
<td>object</td>
<td>type</td>
<td>root</td>
</tr>
<tr>
<td>Marketplace</td>
<td>AggregateRoot</td>
<td>-</td>
</tr>
<tr>
<td>Shop</td>
<td>Entity</td>
<td>MarketPlace</td>
</tr>
<tr>
<td>Consumer</td>
<td>Entity</td>
<td>MarketPlace</td>
</tr>
<tr>
<td>Product</td>
<td>ValueObject</td>
<td>-</td>
</tr>
<tr>
<td>Token</td>
<td>ValueObject</td>
<td>-</td>
</tr>
</table>